<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\EmailSend;
use App\Model\Entity\Notification;
use App\Model\Entity\Token;
use App\Model\Entity\User;
use App\Model\Table\Exceptions\InvalidNotificationCodeException;
use App\Model\Table\Exceptions\MalformedDataException;
use Cake\I18n\FrozenTime;
use Cake\Mailer\MailerAwareTrait;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmailSends Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\NotificationsTable&\Cake\ORM\Association\BelongsTo $Notifications
 * @property \App\Model\Table\EmailResponsesTable&\Cake\ORM\Association\HasMany $EmailResponses
 * @property \App\Model\Table\TokensTable&\Cake\ORM\Association\HasMany $Tokens
 * @method \App\Model\Entity\EmailSend get($primaryKey, $options = [])
 * @method \App\Model\Entity\EmailSend newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EmailSend[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmailSend|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmailSend saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmailSend patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EmailSend[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmailSend findOrCreate($search, callable $callback = null, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @method \App\Model\Entity\EmailSend[]|\Cake\Datasource\ResultSetInterface|false saveMany($entities, $options = [])
 */
class EmailSendsTable extends Table
{
    use MailerAwareTrait;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('email_sends');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsTo('Notifications', [
            'foreignKey' => 'notification_id',
        ]);
        $this->hasMany('EmailResponses', [
            'foreignKey' => 'email_send_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
        $this->hasMany('Tokens', [
            'foreignKey' => 'email_send_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('email_generation_code')
            ->maxLength('email_generation_code', 30)
            ->allowEmptyString('email_generation_code');

        $validator
            ->scalar('email_template')
            ->maxLength('email_template', 30)
            ->allowEmptyString('email_template');

        $validator
            ->boolean('include_token')
            ->notEmptyString('include_token');

        $validator
            ->dateTime('deleted')
            ->allowEmptyDateTime('deleted');

        $validator
            ->dateTime('sent')
            ->allowEmptyDateTime('sent');

        $validator
            ->scalar('message_send_code')
            ->maxLength('message_send_code', 255)
            ->allowEmptyString('message_send_code');

        $validator
            ->scalar('subject')
            ->maxLength('subject', 511)
            ->allowEmptyString('subject');

        $validator
            ->scalar('routing_domain')
            ->maxLength('routing_domain', 255)
            ->allowEmptyString('routing_domain');

        $validator
            ->scalar('from_address')
            ->maxLength('from_address', 511)
            ->allowEmptyString('from_address');

        $validator
            ->scalar('friendly_from')
            ->maxLength('friendly_from', 255)
            ->allowEmptyString('friendly_from');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['notification_id'], 'Notifications'));

        $rules->add($rules->isUnique(['email_generation_code']));
        $rules->add($rules->isUnique(['message_send_code']));

        return $rules;
    }

    /**
     * Is a finder which will return a query with non-live (pre-release & archive) events only.
     *
     * @param \Cake\ORM\Query $query The original query to be modified.
     * @return \Cake\ORM\Query The modified query.
     */
    public function findUnsent(Query $query)
    {
        return $query->where(function ($exp) {
            /** @var \Cake\Database\Expression\QueryExpression $exp */
            return $exp->isNull('sent');
        });
    }

    /**
     * @param string $emailGenerationCode The Email Generation Code
     * @return string[]
     */
    private function codeSplitter(string $emailGenerationCode): array
    {
        return $this->Notifications->NotificationTypes->entityCodeSplitter($emailGenerationCode);
    }

    /**
     * @param string $emailGenerationCode The Code provided to generate the email
     * @return false|string
     */
    private function codeExistValidator(string $emailGenerationCode): string
    {
        $exists = true;
        $iterationNum = 0;
        $newCode = $emailGenerationCode;

        while ($exists) {
            if ($iterationNum == 0) {
                $newCode = $emailGenerationCode;
            } else {
                $newCode = $emailGenerationCode . '-' . $iterationNum;
            }
            $exists = $this->exists(['email_generation_code' => $newCode]);
            $iterationNum += 1;
        }

        return $newCode;
    }

    /**
     * Hashes the password before save
     *
     * @param string $emailGenerationCode The Type & SubType of Token to Make
     * @throws \App\Model\Table\Exceptions\InvalidNotificationCodeException
     * @return \App\Model\Entity\EmailSend|null
     */
    public function make(string $emailGenerationCode): ?EmailSend
    {
        $typeArray = $this->codeSplitter($emailGenerationCode);
        $entity = $this->Notifications->NotificationTypes->getTypeEntity($typeArray['type']);
        if ($entity == 'Users') {
            $user = $this->Users->get($typeArray['entityId']);
            $data = [];
        } elseif ($entity == 'Roles') {
            $role = $this->Users->Roles->get($typeArray['entityId'], ['contain' => 'RoleTypes']);
            $user = $this->Users->get($role->user_id);

            $data = [
                'role_type' => $role->role_type->role_type,
                'role_id' => $role->id,
            ];
        }

        if (!isset($user) || !$user instanceof User || !isset($data)) {
            throw new InvalidNotificationCodeException();
        }

        $notification = $this->Notifications->make($emailGenerationCode, $user, [], $data);

        return $this->generate($notification, $user, $emailGenerationCode);
    }

    /**
     * @param \App\Model\Entity\Notification $notification Notification with Generated Data
     * @param \App\Model\Entity\User $user Notification owning User
     * @param string $emailGenerationCode The Type & SubType of Token to Make
     * @param array $options Options Array for setting Authentication & Token inclusion
     * @return \App\Model\Entity\EmailSend|null
     */
    public function generate(
        Notification $notification,
        User $user,
        string $emailGenerationCode,
        array $options = []
    ): ?EmailSend {
        $notificationType = $this->Notifications->NotificationTypes->getTypeCode($emailGenerationCode);
        $emailGenerationCode = $this->codeExistValidator($emailGenerationCode);

        $defaultOptions = [
            'includeToken' => true,
            'authenticate' => true,
        ];
        $options = array_merge($defaultOptions, $options);

        $data = [
            EmailSend::FIELD_NOTIFICATION_ID => $notification->id,
            EmailSend::FIELD_EMAIL_GENERATION_CODE => $emailGenerationCode,
            EmailSend::FIELD_SENT => null,
            EmailSend::FIELD_USER_ID => $user->id,
            EmailSend::FIELD_SUBJECT => $notification->notification_header,
            EmailSend::FIELD_EMAIL_TEMPLATE => $notificationType->content_template,
            EmailSend::FIELD_INCLUDE_TOKEN => $options['includeToken'],
        ];

        $associations = [];

        if ($options['includeToken']) {
            $redirect = $this->Notifications->NotificationTypes->buildNotificationLink($notificationType);

            $tokenData = [
                EmailSend::FIELD_TOKENS => [
                    [
                        Token::FIELD_TOKEN => 'Token for ' . $notification->notification_header,
                        Token::FIELD_TOKEN_HEADER => [
                            'redirect' => $redirect,
                            'authenticate' => $options['authenticate'],
                        ],
                    ],
                ],
            ];
            $data = array_merge($data, $tokenData);
            $associations = ['associated' => ['Tokens']];
        }

        $sendEntity = $this->newEntity($data);

        if ($this->save($sendEntity, $associations)) {
            return $sendEntity;
        }

        throw new MalformedDataException();
    }

    /**
     * Dispatches the Email using the Mailer
     *
     * @param int $emailSendId The ID of the Email Send
     * @return bool
     */
    public function send(int $emailSendId): bool
    {
        if (!$this->exists(['id' => $emailSendId])) {
            return false;
        }
        $email = $this->get($emailSendId, ['contain' => ['Tokens', 'Users', 'Notifications.NotificationTypes']]);

        $token = null;

        if ($email->include_token && $email->has('tokens')) {
            $token = $email->tokens[0];
            if ($token instanceof Token) {
                $token = $this->Tokens->buildToken((int)$token->get($token::FIELD_ID));
            } else {
                $token = null;
            }
        }

        $type = '';
        $entityId = 0;
        extract($this->codeSplitter($email->email_generation_code));

        switch ($type) {
            case 'USR':
                $entity = $this->Users->get($entityId);
                break;
            default:
                $entity = null;
        }

        /** @var \App\Mailer\BasicMailer $mailer */
        $mailer = $this->getMailer('Basic');
        $mailer->send('doSend', [$email, $token, $entity, $email->notification]);

        $email->set('sent', FrozenTime::now());
        $this->save($email, ['validate' => false]);

        return true;
    }

    /**
     * Makes an Email Dispatch Event and then despatches it.
     *
     * @param string $emailGenerationCode The Type & SubType of Token to Make
     * @return bool
     */
    public function makeAndSend(string $emailGenerationCode): bool
    {
        $emailSend = $this->make($emailGenerationCode);

        if (!$emailSend instanceof EmailSend) {
            return false;
        }

        if ($this->send($emailSend->id)) {
            return true;
        }

        return false;
    }

    /**
     * Makes an Email Dispatch Event and then dispatches it.
     *
     * @param array $results The Returned Results Array
     * @param array $sendHeaders The Send Headers
     * @return bool
     */
    public function sendRegister(array $results, array $sendHeaders): bool
    {
        if (!key_exists('X-Gen-ID', $sendHeaders)) {
            $emailSend = $this->newEmptyEntity();
        } else {
            $emailSend = $this->get($sendHeaders['X-Gen-ID']);
        }

        if (key_exists('results', $results)) {
            $results = $results['results'];
        }
        if (key_exists('id', $results)) {
            $emailSend->set('message_send_code', $results['id']);
        }
        $emailSend->set('sent', FrozenTime::now());

        $this->save($emailSend);

        return true;
    }
}

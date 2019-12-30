<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Token;
use App\Utility\TextSafe;
use Cake\Database\Schema\TableSchema;
use Cake\Event\Event;
use Cake\I18n\FrozenTime;
use Cake\I18n\Time;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Security;
use Cake\Validation\Validator;

/**
 * Tokens Model
 *
 * @property \App\Model\Table\EmailSendsTable&\Cake\ORM\Association\BelongsTo $EmailSends
 *
 * @method \App\Model\Entity\Token get($primaryKey, $options = [])
 * @method \App\Model\Entity\Token newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Token[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Token|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Token patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Token[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Token findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @method \App\Model\Entity\Token saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @mixin \Muffin\Trash\Model\Behavior\TrashBehavior
 */
class TokensTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('tokens');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'modified' => 'always',
                ],
            ],
        ]);

        $this->addBehavior('Muffin/Trash.Trash', [
            'field' => 'deleted',
        ]);

        $this->belongsTo('EmailSends', [
            'foreignKey' => 'email_send_id',
            'joinType' => 'INNER',
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
            ->scalar('token')
            ->maxLength('token', 511)
            ->requirePresence('token', 'create')
            ->notEmptyString('token');

        $validator
            ->dateTime('expires')
            ->allowEmptyDateTime('expires');

        $validator
            ->dateTime('utilised')
            ->allowEmptyDateTime('utilised');

        $validator
            ->boolean('active')
            ->allowEmptyString('active');

        $validator
            ->scalar('hash')
            ->maxLength('hash', 511)
            ->allowEmptyString('hash');

        $validator
            ->integer('random_number')
            ->allowEmptyString('random_number');

        $validator
            ->requirePresence('token_header', 'create')
            ->notEmptyString('token_header');

        return $validator;
    }

    /**
     * @param \Cake\Database\Schema\TableSchema $schema The Schema to be modified
     *
     * @return \Cake\Database\Schema\TableSchema
     *
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _initializeSchema(TableSchema $schema): TableSchema
    {
        $schema->setColumnType('token_header', 'json');

        return $schema;
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
        $rules->add($rules->existsIn(['email_send_id'], 'EmailSends'));

        return $rules;
    }

    /**
     *
     * @param \Cake\Event\Event $event The Event to be processed
     * @param \App\Model\Table\ArrayObject $data The data to be modified
     * @param \App\Model\Table\ArrayObject $options The Options Contained
     *
     * @return void
     */
    public function beforeMarshal(Event $event, $data, $options)
    {
        if (!isset($data['active'])) {
            // Sets Active
            $data['active'] = true;
        }
    }

    /**
     * Hashes the password before save
     *
     * @param \Cake\Event\Event $event The event trigger.
     *
     * @return true
     *
     * @throws \Exception
     */
    public function beforeSave(Event $event)
    {
        /** @var \App\Model\Entity\Token $entity */
        $entity = $event->getData('entity');

        if ($entity->isNew()) {
            $entity->random_number = unpack('n', Security::randomBytes(64))[1];

            // Set Expiry Date
            $now = Time::now();
            $entity->expires = $now->addMonth(1);
        }

        return true;
    }

    /**
     * @param int $tokenId The Id of the Token
     *
     * @return string
     */
    public function prepareToken($tokenId)
    {
        $tokenRow = $this->get($tokenId, ['contain' => 'EmailSends']);

        $decrypter = Security::randomBytes(64);
        $decrypter = base64_encode($decrypter);
        $decrypter = substr($decrypter, 0, 8);

        $hash = $decrypter . $tokenRow->created . $tokenRow->random_number . $tokenRow->email_send->user_id;

        $hash = Security::hash($hash, 'sha256');

        $tokenRow->set('hash', $hash);
        $this->save($tokenRow);

        $tokenData = [
            'id' => $tokenId,
            'random_number' => $tokenRow->random_number,
        ];

        $token = json_encode($tokenData);
        $token = base64_encode($token);

        $token = $decrypter . $token;
        $token = TextSafe::encode($token);

        return $token;
    }

    /**
     * @param int $tokenId The Id of the Token
     *
     * @return string
     */
    public function buildToken($tokenId)
    {
        $token = $this->prepareToken($tokenId);
        $token = urlencode($token);

        return $token;
    }

    /**
     * @param string $token The Token to be Validated & Decrypted
     *
     * @return int|bool $validation Containing the validation state & id
     */
    public function validateToken($token)
    {
        $token = urldecode($token);
        $token = TextSafe::decode($token);
        $decrypter = substr($token, 0, 8);

        $token = substr($token, 8);
        $token = base64_decode($token);
        $token = json_decode($token);

        if (!is_object($token)) {
            return false;
        }

        $tokenRow = $this->get($token->id, ['contain' => 'EmailSends']);

        if (!$tokenRow->active) {
            return false;
        }

        $tokenRow->set('utilised', Time::now());
        $this->save($tokenRow);

        if ($tokenRow->random_number <> $token->random_number) {
            return false;
        }

        $testHash = $decrypter . $tokenRow->created . $tokenRow->random_number . $tokenRow->email_send->user_id;
        $testHash = Security::hash($testHash, 'sha256');

        $tokenRowHash = $tokenRow['hash'];

        if ($testHash == $tokenRowHash) {
            return $token->id;
        }

        return false;
    }

    public const CLEAN_NO_CLEAN = 0;
    public const CLEAN_DEACTIVATE = 1;
    public const CLEAN_DELETED = 2;

    /**
     * @param \App\Model\Entity\Token $token The token to be cleaned.
     *
     * @return int
     */
    public function cleanToken($token)
    {
        /** @var \Cake\I18n\FrozenTime $expiry */
        $expiry = $token->get(Token::FIELD_EXPIRES);
        /** @var bool $active */
        $active = $token->get(Token::FIELD_ACTIVE);

        if (!$expiry->isFuture() && $active) {
            $token->set(Token::FIELD_ACTIVE, false);
            $this->save($token);

            return self::CLEAN_DEACTIVATE;
        }

        $now = FrozenTime::now();
        $monthAgo = $now->subMonth();

        if (!$active && $expiry->lt($monthAgo)) {
            $this->delete($token);

            return self::CLEAN_DELETED;
        }

        return self::CLEAN_NO_CLEAN;
    }

    /**
     * Clean Tokens
     *
     * @return array
     */
    public function cleanAllTokens()
    {
        $noChange = 0;
        $deactivated = 0;
        $deleted = 0;

        $tokens = $this->find('all');

        foreach ($tokens as $token) {
            $response = $this->cleanToken($token);

            switch ($response) {
                case self::CLEAN_NO_CLEAN:
                    $noChange += 1;
                    break;
                case self::CLEAN_DEACTIVATE:
                    $deactivated += 1;
                    break;
                case self::CLEAN_DELETED:
                    $deleted += 1;
                    break;
            }
        }

        return [
            'no_change' => $noChange,
            'deactivated' => $deactivated,
            'deleted' => $deleted,
        ];
    }

    /**
     * @param array $requestQueryParams Request Query Params
     *
     * @return false|\App\Model\Entity\Token
     */
    public function validateTokenRequest($requestQueryParams)
    {
        if (key_exists('token', $requestQueryParams)) {
            $token = $requestQueryParams['token'];
        }
        if (key_exists('token', $requestQueryParams)) {
            $tokenId = $requestQueryParams['token_id'];
        }

        if (isset($token) && isset($tokenId)) {
            $valid = $this->validateToken($token);

            if ($valid && $valid == $tokenId) {
                /** @var \App\Model\Entity\Token $tokenRow */
                return $this->get($valid, ['contain' => 'EmailSends.Users']);
            }
        }

        return false;
    }
}

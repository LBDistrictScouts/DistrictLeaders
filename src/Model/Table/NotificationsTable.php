<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Notification;
use App\Model\Entity\NotificationType;
use App\Model\Entity\User;
use App\Model\Table\Exceptions\MalformedDataException;
use Cake\Database\Schema\TableSchemaInterface;
use Cake\I18n\FrozenTime;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Notifications Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\NotificationTypesTable&\Cake\ORM\Association\BelongsTo $NotificationTypes
 * @property \App\Model\Table\EmailSendsTable&\Cake\ORM\Association\HasMany $EmailSends
 * @method \App\Model\Entity\Notification get($primaryKey, $options = [])
 * @method \App\Model\Entity\Notification newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Notification[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Notification|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Notification saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Notification patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Notification[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Notification findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Notification[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Muffin\Trash\Model\Behavior\TrashBehavior
 * @method \App\Model\Entity\Notification newEmptyEntity()
 * @method \App\Model\Entity\Notification[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Notification[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Notification[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class NotificationsTable extends Table
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

        $this->setTable('notifications');
        $this->setDisplayField(Notification::FIELD_NOTIFICATION_HEADER);
        $this->setPrimaryKey(Notification::FIELD_ID);

        $this->addBehavior('Timestamp');
        $this->addBehavior('Muffin/Trash.Trash');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsTo('NotificationTypes', [
            'foreignKey' => 'notification_type_id',
        ]);
        $this->hasMany('EmailSends', [
            'foreignKey' => 'notification_id',
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
            ->integer(Notification::FIELD_ID)
            ->allowEmptyString(Notification::FIELD_ID, null, 'create');

        $validator
            ->scalar(Notification::FIELD_NOTIFICATION_HEADER)
            ->requirePresence(Notification::FIELD_NOTIFICATION_HEADER, 'create')
            ->maxLength(Notification::FIELD_NOTIFICATION_HEADER, 255)
            ->notEmptyString(Notification::FIELD_NOTIFICATION_HEADER);

        $validator
            ->integer(Notification::FIELD_NOTIFICATION_TYPE_ID)
            ->requirePresence(Notification::FIELD_NOTIFICATION_TYPE_ID, 'create')
            ->notEmptyString(Notification::FIELD_NOTIFICATION_TYPE_ID);

        $validator
            ->dateTime(Notification::FIELD_READ_DATE)
            ->allowEmptyDateTime(Notification::FIELD_READ_DATE);

        $validator
            ->scalar(Notification::FIELD_NOTIFICATION_SOURCE)
            ->requirePresence(Notification::FIELD_NOTIFICATION_SOURCE, 'create')
            ->maxLength(Notification::FIELD_NOTIFICATION_SOURCE, 63)
            ->notEmptyString(Notification::FIELD_NOTIFICATION_SOURCE);

        $validator
            ->dateTime(Notification::FIELD_DELETED)
            ->allowEmptyDateTime(Notification::FIELD_DELETED);

        $validator
            ->allowEmptyArray(Notification::FIELD_BODY_CONTENT);

        $validator
            ->allowEmptyArray(Notification::FIELD_SUBJECT_LINK);

        return $validator;
    }

    /**
     * @param \Cake\Database\Schema\TableSchemaInterface $schema The Schema to be modified
     * @return \Cake\Database\Schema\TableSchemaInterface
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _initializeSchema(TableSchemaInterface $schema): TableSchemaInterface
    {
        $schema->setColumnType(Notification::FIELD_BODY_CONTENT, 'json');
        $schema->setColumnType(Notification::FIELD_SUBJECT_LINK, 'json');

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
        $rules->add($rules->existsIn([Notification::FIELD_USER_ID], 'Users'));
        $rules->add($rules->existsIn([Notification::FIELD_NOTIFICATION_TYPE_ID], 'NotificationTypes'));

        return $rules;
    }

    /**
     * @param \Cake\ORM\Query $query Query for Modification
     * @return \Cake\ORM\Query
     */
    public function findUnread(Query $query): Query
    {
        return $query->whereNull(Notification::FIELD_READ_DATE);
    }

    /**
     * @param \App\Model\Entity\Notification $notification Notification to be Read
     * @return bool
     */
    public function markRead(Notification $notification): bool
    {
        $notification->set(Notification::FIELD_READ_DATE, FrozenTime::now());

        return (bool)$this->save($notification);
    }

    /**
     * Function to return Email Generation Code String
     *
     * @param \App\Model\Entity\Notification $notification The notification entity
     * @return string
     */
    public function getEmailGenerationCode(Notification $notification): string
    {
        $notificationType = $this->NotificationTypes->get($notification->notification_type_id);

        return $notificationType->type . '-' . (string)$notification->user_id . '-' . $notificationType->sub_type;
    }

    /**
     * @param string $emailGenerationCode Email Send Style Notification Entity Code
     * @param \App\Model\Entity\User $user Notification User Entity
     * @param array|null $body Starting Body for Notification
     * @param array|null $data Additional Notification Context Data
     * @return \App\Model\Entity\Notification
     */
    public function make(
        string $emailGenerationCode,
        User $user,
        ?array $body = [],
        ?array $data = []
    ): Notification {
        $notificationType = $this->NotificationTypes->getTypeCode($emailGenerationCode);

        // Prevent none repetitive notifications from repeating
        $exists = $this->checkShouldMake($notificationType, $emailGenerationCode, $user);
        if ($exists instanceof Notification) {
            return $exists;
        }

        $codeParts = $this->NotificationTypes->entityCodeSplitter($emailGenerationCode);
        $notificationCode = $codeParts['type'] . '-' . $codeParts['entityId'] . '-' . $codeParts['subType'];

        $header = $this->NotificationTypes->buildNotificationHeader($notificationType, $user, $data);
        $link = $this->NotificationTypes->buildNotificationLink($notificationType, $data);

        if (empty($body)) {
            $body = $data;
        }

        $notification = $this->newEntity([
            Notification::FIELD_USER_ID => $user->id,
            Notification::FIELD_NOTIFICATION_TYPE_ID => $notificationType->id,
            Notification::FIELD_NOTIFICATION_HEADER => $header,
            Notification::FIELD_NOTIFICATION_SOURCE => $notificationCode,
            Notification::FIELD_BODY_CONTENT => $body,
            Notification::FIELD_SUBJECT_LINK => $link,
        ]);

        if ($this->save($notification)) {
            return $notification;
        }

        throw new MalformedDataException();
    }

    /**
     * Function to determine if a Notification should be made or if it already exists
     *
     * @param \App\Model\Entity\NotificationType $notificationType The Notification Type
     * @param string $emailGenerationCode Generation Code
     * @param \App\Model\Entity\User $user User for Existing Check
     * @return true|\App\Model\Entity\Notification
     */
    protected function checkShouldMake(NotificationType $notificationType, string $emailGenerationCode, User $user)
    {
        if ($notificationType->repetitive) {
            return true;
        }

        $codeParts = $this->NotificationTypes->entityCodeSplitter($emailGenerationCode);
        $notificationCode = $codeParts['type'] . '-' . $codeParts['entityId'] . '-' . $codeParts['subType'];

        $findData = [
            Notification::FIELD_USER_ID => $user->id,
            Notification::FIELD_NOTIFICATION_SOURCE => $notificationCode,
        ];

        if ($this->exists($findData)) {
            $notification = $this->find()->where($findData)->firstOrFail();
            if ($notification instanceof Notification) {
                return $notification;
            }
        }

        return true;
    }

    /**
     * @param \App\Model\Entity\User $user The User for initiating welcome notification
     * @return \App\Model\Entity\Notification
     */
    public function welcome(User $user): Notification
    {
        $emailGenerationCode = 'USR-' . $user->id . '-NEW';

        $body = [];

        $creator = $this->Users->determineUserCreator($user);
        if ($creator instanceof User) {
            $body['creator'] = $creator->full_name;
        }

        return $this->make($emailGenerationCode, $user, $body);
    }
}

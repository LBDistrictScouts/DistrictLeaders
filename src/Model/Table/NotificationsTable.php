<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Notification;
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
 * @method \App\Model\Entity\Notification newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Notification[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Notification|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Notification saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Notification patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Notification[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Notification findOrCreate($search, callable $callback = null, $options = [])
 * @method \App\Model\Entity\Notification[]|\Cake\Datasource\ResultSetInterface|false saveMany($entities, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Muffin\Trash\Model\Behavior\TrashBehavior
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
            ->requirePresence(Notification::FIELD_NOTIFICATION_HEADER)
            ->maxLength(Notification::FIELD_NOTIFICATION_HEADER, 45)
            ->allowEmptyString(Notification::FIELD_NOTIFICATION_HEADER);

        $validator
            ->dateTime(Notification::FIELD_READ_DATE)
            ->allowEmptyDateTime(Notification::FIELD_READ_DATE);

        $validator
            ->scalar(Notification::FIELD_NOTIFICATION_SOURCE)
            ->maxLength(Notification::FIELD_NOTIFICATION_SOURCE, 63)
            ->allowEmptyString(Notification::FIELD_NOTIFICATION_SOURCE);

        $validator
            ->dateTime(Notification::FIELD_DELETED)
            ->allowEmptyDateTime(Notification::FIELD_DELETED);

        $validator
            ->notEmptyString(Notification::FIELD_BODY_CONTENT);

        $validator
            ->allowEmptyString(Notification::FIELD_SUBJECT_LINK);

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
}

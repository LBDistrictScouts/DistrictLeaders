<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Notification;
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
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @method \App\Model\Entity\Notification[]|\Cake\Datasource\ResultSetInterface|false saveMany($entities, $options = [])
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
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->boolean('new')
            ->allowEmptyString('new');

        $validator
            ->scalar('notification_header')
            ->requirePresence('notification_header')
            ->maxLength('notification_header', 45)
            ->allowEmptyString('notification_header');

        $validator
            ->scalar('text')
            ->maxLength('text', 999)
            ->allowEmptyString('text');

        $validator
            ->dateTime('read_date')
            ->allowEmptyDateTime('read_date');

        $validator
            ->scalar('notification_source')
            ->maxLength('notification_source', 63)
            ->allowEmptyString('notification_source');

        $validator
            ->numeric('link_id')
            ->allowEmptyString('link_id');

        $validator
            ->scalar('link_controller')
            ->maxLength('link_controller', 45)
            ->notEmptyString('link_controller');

        $validator
            ->scalar('link_prefix')
            ->maxLength('link_prefix', 45)
            ->allowEmptyString('link_prefix');

        $validator
            ->scalar('link_action')
            ->maxLength('link_action', 45)
            ->notEmptyString('link_action');

        $validator
            ->dateTime('deleted')
            ->allowEmptyDateTime('deleted');

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
        $rules->add($rules->existsIn(['notification_type_id'], 'NotificationTypes'));

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

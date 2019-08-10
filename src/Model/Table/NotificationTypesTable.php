<?php
namespace App\Model\Table;

use App\Model\Entity\NotificationType;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * NotificationTypes Model
 *
 * @property \App\Model\Table\NotificationsTable&\Cake\ORM\Association\HasMany $Notifications
 *
 * @method NotificationType get($primaryKey, $options = [])
 * @method NotificationType newEntity($data = null, array $options = [])
 * @method NotificationType[] newEntities(array $data, array $options = [])
 * @method NotificationType|false save(EntityInterface $entity, $options = [])
 * @method NotificationType saveOrFail(EntityInterface $entity, $options = [])
 * @method NotificationType patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method NotificationType[] patchEntities($entities, array $data, array $options = [])
 * @method NotificationType findOrCreate($search, callable $callback = null, $options = [])
 */
class NotificationTypesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('notification_types');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Notifications', [
            'foreignKey' => 'notification_type_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('notification_type')
            ->maxLength('notification_type', 45)
            ->allowEmptyString('notification_type');

        $validator
            ->scalar('notification_description')
            ->maxLength('notification_description', 255)
            ->allowEmptyString('notification_description');

        $validator
            ->scalar('icon')
            ->maxLength('icon', 45)
            ->allowEmptyString('icon');

        $validator
            ->scalar('type_code')
            ->maxLength('type_code', 7)
            ->notEmptyString('type_code');

        return $validator;
    }
}

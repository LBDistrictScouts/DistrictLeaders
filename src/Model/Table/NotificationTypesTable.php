<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\NotificationType;
use App\Model\Table\Traits\BaseInstallerTrait;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * NotificationTypes Model
 *
 * @property \App\Model\Table\NotificationsTable&\Cake\ORM\Association\HasMany $Notifications
 * @method \App\Model\Entity\NotificationType get($primaryKey, $options = [])
 * @method \App\Model\Entity\NotificationType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\NotificationType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\NotificationType|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NotificationType saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NotificationType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\NotificationType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\NotificationType findOrCreate($search, callable $callback = null, $options = [])
 * @method \App\Model\Entity\NotificationType[]|\Cake\Datasource\ResultSetInterface|false saveMany($entities, $options = [])
 */
class NotificationTypesTable extends Table
{
    use BaseInstallerTrait;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('notification_types');
        $this->setDisplayField(NotificationType::FIELD_NOTIFICATION_TYPE);
        $this->setPrimaryKey(NotificationType::FIELD_ID);

        $this->hasMany('Notifications', [
            'foreignKey' => 'notification_type_id',
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
            ->integer(NotificationType::FIELD_ID)
            ->allowEmptyString(NotificationType::FIELD_ID, null, 'create');

        $validator
            ->scalar(NotificationType::FIELD_NOTIFICATION_TYPE)
            ->requirePresence(NotificationType::FIELD_NOTIFICATION_TYPE)
            ->maxLength(NotificationType::FIELD_NOTIFICATION_TYPE, 45)
            ->notEmptyString(NotificationType::FIELD_NOTIFICATION_TYPE);

        $validator
            ->scalar(NotificationType::FIELD_NOTIFICATION_DESCRIPTION)
            ->requirePresence(NotificationType::FIELD_NOTIFICATION_DESCRIPTION)
            ->maxLength(NotificationType::FIELD_NOTIFICATION_DESCRIPTION, 255)
            ->notEmptyString(NotificationType::FIELD_NOTIFICATION_DESCRIPTION);

        $validator
            ->scalar(NotificationType::FIELD_ICON)
            ->requirePresence(NotificationType::FIELD_ICON)
            ->maxLength(NotificationType::FIELD_ICON, 45)
            ->notEmptyString(NotificationType::FIELD_ICON);

        $validator
            ->scalar(NotificationType::FIELD_TYPE_CODE)
            ->requirePresence(NotificationType::FIELD_TYPE_CODE)
            ->maxLength(NotificationType::FIELD_TYPE_CODE, 7)
            ->notEmptyString(NotificationType::FIELD_TYPE_CODE);

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
        $rules->add($rules->isUnique(['notification_type']));
        $rules->add($rules->isUnique(['type_code']));

        return $rules;
    }

    /**
     * install the application status config
     *
     * @return int
     */
    public function installBaseNotificationTypes()
    {
        return $this->installBase($this);
    }

    /**
     * install the application status config
     *
     * @param string $type The Type of the Notification
     * @param string $subtype The SubType
     * @return mixed
     */
    public function getTypeCode($type, $subtype)
    {
        $code = $type . '-' . $subtype;

        if ($this->exists(['type_code' => $code])) {
            return $this->find()->where(['type_code' => $code])->first()->id;
        }

        return $this->find()->where(['type_code' => 'GEN-NOT'])->first()->id;
    }
}

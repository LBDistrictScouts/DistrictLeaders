<?php
namespace App\Model\Table;

use App\Model\Entity\UserContactType;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UserContactTypes Model
 *
 * @property \App\Model\Table\UserContactsTable&\Cake\ORM\Association\HasMany $UserContacts
 *
 * @method UserContactType get($primaryKey, $options = [])
 * @method UserContactType newEntity($data = null, array $options = [])
 * @method UserContactType[] newEntities(array $data, array $options = [])
 * @method UserContactType|false save(EntityInterface $entity, $options = [])
 * @method UserContactType saveOrFail(EntityInterface $entity, $options = [])
 * @method UserContactType patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method UserContactType[] patchEntities($entities, array $data, array $options = [])
 * @method UserContactType findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UserContactTypesTable extends Table
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

        $this->setTable('user_contact_types');
        $this->setDisplayField('user_contact_type');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('UserContacts', [
            'foreignKey' => 'user_contact_type_id'
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
            ->scalar('user_contact_type')
            ->maxLength('user_contact_type', 32)
            ->requirePresence('user_contact_type', 'create')
            ->notEmptyString('user_contact_type')
            ->add('user_contact_type', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['user_contact_type']));

        return $rules;
    }
}

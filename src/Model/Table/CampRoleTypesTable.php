<?php
namespace App\Model\Table;

use App\Model\Entity\CampRoleType;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CampRoleTypes Model
 *
 * @property \App\Model\Table\CampRolesTable&\Cake\ORM\Association\HasMany $CampRoles
 *
 * @method CampRoleType get($primaryKey, $options = [])
 * @method CampRoleType newEntity($data = null, array $options = [])
 * @method CampRoleType[] newEntities(array $data, array $options = [])
 * @method CampRoleType|false save(EntityInterface $entity, $options = [])
 * @method CampRoleType saveOrFail(EntityInterface $entity, $options = [])
 * @method CampRoleType patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method CampRoleType[] patchEntities($entities, array $data, array $options = [])
 * @method CampRoleType findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CampRoleTypesTable extends Table
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

        $this->setTable('camp_role_types');
        $this->setDisplayField('camp_role_type');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('CampRoles', [
            'foreignKey' => 'camp_role_type_id'
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
            ->scalar('camp_role_type')
            ->maxLength('camp_role_type', 30)
            ->requirePresence('camp_role_type', 'create')
            ->notEmptyString('camp_role_type')
            ->add('camp_role_type', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
        $rules->add($rules->isUnique(['camp_role_type']));

        return $rules;
    }
}

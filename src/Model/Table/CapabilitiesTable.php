<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Capabilities Model
 *
 * @property \App\Model\Table\RoleTypesTable|\Cake\ORM\Association\BelongsToMany $RoleTypes
 *
 * @method \App\Model\Entity\Capability get($primaryKey, $options = [])
 * @method \App\Model\Entity\Capability newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Capability[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Capability|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Capability|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Capability patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Capability[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Capability findOrCreate($search, callable $callback = null, $options = [])
 */
class CapabilitiesTable extends Table
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

        $this->setTable('capabilities');
        $this->setDisplayField('capability_code');
        $this->setPrimaryKey('id');

        $this->belongsToMany('RoleTypes', [
            'joinTable' => 'capabilities_role_types',

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
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('capability_code')
            ->maxLength('capability_code', 10)
            ->requirePresence('capability_code', 'create')
            ->notEmpty('capability_code')
            ->add('capability_code', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('capability')
            ->maxLength('capability', 255)
            ->requirePresence('capability', 'create')
            ->notEmpty('capability')
            ->add('capability', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->integer('min_level')
            ->requirePresence('min_level', 'create')
            ->notEmpty('min_level');

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
        $rules->add($rules->isUnique(['capability_code']));
        $rules->add($rules->isUnique(['capability']));

        return $rules;
    }
}

<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CapabilitiesRoleTypes Model
 *
 * @property \App\Model\Table\CapabilitiesTable|\Cake\ORM\Association\BelongsTo $Capabilities
 * @property \App\Model\Table\RoleTypesTable|\Cake\ORM\Association\BelongsTo $RoleTypes
 *
 * @method \App\Model\Entity\CapabilitiesRoleType get($primaryKey, $options = [])
 * @method \App\Model\Entity\CapabilitiesRoleType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CapabilitiesRoleType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CapabilitiesRoleType|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CapabilitiesRoleType saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CapabilitiesRoleType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CapabilitiesRoleType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CapabilitiesRoleType findOrCreate($search, callable $callback = null, $options = [])
 */
class CapabilitiesRoleTypesTable extends Table
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

        $this->setTable('capabilities_role_types');
        $this->setDisplayField('capability_id');
        $this->setPrimaryKey(['capability_id', 'role_type_id']);

        $this->belongsTo('Capabilities', [
            'foreignKey' => 'capability_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('RoleTypes', [
            'foreignKey' => 'role_type_id',
            'joinType' => 'INNER'
        ]);
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
        $rules->add($rules->existsIn(['capability_id'], 'Capabilities'));
        $rules->add($rules->existsIn(['role_type_id'], 'RoleTypes'));

        return $rules;
    }
}
<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CapabilitiesRoleTypes Model
 *
 * @property \App\Model\Table\CapabilitiesTable&\App\Model\Table\BelongsTo $Capabilities
 * @property \App\Model\Table\RoleTypesTable&\App\Model\Table\BelongsTo $RoleTypes
 * @method \App\Model\Entity\CapabilitiesRoleType get($primaryKey, $options = [])
 * @method \App\Model\Entity\CapabilitiesRoleType newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\CapabilitiesRoleType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CapabilitiesRoleType|false save(\App\Model\Table\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CapabilitiesRoleType saveOrFail(\App\Model\Table\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CapabilitiesRoleType patchEntity(\App\Model\Table\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CapabilitiesRoleType[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CapabilitiesRoleType findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\CapabilitiesRoleType[]|\App\Model\Table\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CapabilitiesRoleType newEmptyEntity()
 * @method \App\Model\Entity\CapabilitiesRoleType[]|\App\Model\Table\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\CapabilitiesRoleType[]|\App\Model\Table\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CapabilitiesRoleType[]|\App\Model\Table\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class CapabilitiesRoleTypesTable extends Table
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

        $this->setTable('capabilities_role_types');
        $this->setDisplayField('capability_id');
        $this->setPrimaryKey(['capability_id', 'role_type_id']);

        $this->belongsTo('Capabilities', [
            'foreignKey' => 'capability_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('RoleTypes', [
            'foreignKey' => 'role_type_id',
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
            ->boolean('template')
            ->notEmptyString('template');

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
        $rules->add($rules->existsIn(['capability_id'], 'Capabilities'));
        $rules->add($rules->existsIn(['role_type_id'], 'RoleTypes'));

        return $rules;
    }
}

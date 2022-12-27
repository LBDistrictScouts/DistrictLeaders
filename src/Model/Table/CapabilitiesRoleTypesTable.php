<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\CapabilitiesRoleType;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CapabilitiesRoleTypes Model
 *
 * @property CapabilitiesTable&BelongsTo $Capabilities
 * @property RoleTypesTable&BelongsTo $RoleTypes
 * @method CapabilitiesRoleType get($primaryKey, $options = [])
 * @method CapabilitiesRoleType newEntity(array $data, array $options = [])
 * @method CapabilitiesRoleType[] newEntities(array $data, array $options = [])
 * @method CapabilitiesRoleType|false save(EntityInterface $entity, $options = [])
 * @method CapabilitiesRoleType saveOrFail(EntityInterface $entity, $options = [])
 * @method CapabilitiesRoleType patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method CapabilitiesRoleType[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method CapabilitiesRoleType findOrCreate($search, ?callable $callback = null, $options = [])
 * @method CapabilitiesRoleType[]|ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method CapabilitiesRoleType newEmptyEntity()
 * @method CapabilitiesRoleType[]|ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method CapabilitiesRoleType[]|ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method CapabilitiesRoleType[]|ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
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
     * @param Validator $validator Validator instance.
     * @return Validator
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
     * @param RulesChecker $rules The rules object to be modified.
     * @return RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['capability_id'], 'Capabilities'));
        $rules->add($rules->existsIn(['role_type_id'], 'RoleTypes'));

        return $rules;
    }
}

<?php
namespace App\Model\Table;

use App\Model\Entity\RoleType;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RoleTypes Model
 *
 * @property \App\Model\Table\SectionTypesTable&\Cake\ORM\Association\BelongsTo $SectionTypes
 * @property \App\Model\Table\RolesTable&\Cake\ORM\Association\HasMany $Roles
 * @property \App\Model\Table\CapabilitiesTable&\Cake\ORM\Association\BelongsToMany $Capabilities
 *
 * @method \App\Model\Entity\RoleType get($primaryKey, $options = [])
 * @method \App\Model\Entity\RoleType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RoleType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RoleType|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RoleType saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RoleType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RoleType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RoleType findOrCreate($search, callable $callback = null, $options = [])
 * @property \App\Model\Table\CapabilitiesRoleTypesTable&\Cake\ORM\Association\HasMany $CapabilitiesRoleTypes
 */
class RoleTypesTable extends Table
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

        $this->setTable('role_types');
        $this->setDisplayField('role_abbreviation');
        $this->setPrimaryKey('id');

        $this->belongsTo('SectionTypes', [
            'foreignKey' => 'section_type_id'
        ]);
        $this->hasMany('Roles', [
            'foreignKey' => 'role_type_id'
        ]);
        $this->belongsToMany('Capabilities', [
            'foreignKey' => 'role_type_id',
            'targetForeignKey' => 'capability_id',
            'joinTable' => 'capabilities_role_types'
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
            ->allowEmptyString('id');

        $validator
            ->scalar('role_type')
            ->maxLength('role_type', 255)
            ->requirePresence('role_type', 'create')
            ->notEmptyString('role_type');

        $validator
            ->scalar('role_abbreviation')
            ->maxLength('role_abbreviation', 32)
            ->allowEmptyString('role_abbreviation');

        $validator
            ->integer('level')
            ->requirePresence('level', 'create')
            ->notEmptyString('level');

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
        $rules->add($rules->existsIn(['section_type_id'], 'SectionTypes'));
        $rules->add($rules->isUnique(['role_type']));
        $rules->add($rules->isUnique(['role_abbreviation']));

        return $rules;
    }
}

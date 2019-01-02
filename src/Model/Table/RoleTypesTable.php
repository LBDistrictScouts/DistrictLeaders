<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RoleTypes Model
 *
 * @property \App\Model\Table\SectionTypesTable|\Cake\ORM\Association\BelongsTo $SectionTypes
 * @property \App\Model\Table\RoleTypesTable|\Cake\ORM\Association\BelongsToMany $Capabilities
 * @property \App\Model\Table\RolesTable|\Cake\ORM\Association\HasMany $Roles
 *
 * @method \App\Model\Entity\RoleType get($primaryKey, $options = [])
 * @method \App\Model\Entity\RoleType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RoleType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RoleType|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RoleType|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RoleType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RoleType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RoleType findOrCreate($search, callable $callback = null, $options = [])
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
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('SectionTypes', [
            'foreignKey' => 'section_type_id'
        ]);
        $this->hasMany('Roles', [
            'foreignKey' => 'role_type_id'
        ]);
        $this->belongsToMany('Capabilities', [
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
            ->scalar('role_type')
            ->maxLength('role_type', 255)
            ->requirePresence('role_type', 'create')
            ->notEmpty('role_type');

        $validator
            ->scalar('role_abbreviation')
            ->maxLength('role_abbreviation', 32)
            ->allowEmpty('role_abbreviation');

        $validator
            ->integer('level')
            ->requirePresence('level', 'create')
            ->notEmpty('level');

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

        return $rules;
    }
}

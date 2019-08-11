<?php
namespace App\Model\Table;

use App\Model\Entity\SectionType;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SectionTypes Model
 *
 * @property \App\Model\Table\RoleTypesTable&\Cake\ORM\Association\HasMany $RoleTypes
 * @property \App\Model\Table\SectionsTable&\Cake\ORM\Association\HasMany $Sections
 *
 * @method \App\Model\Entity\SectionType get($primaryKey, $options = [])
 * @method \App\Model\Entity\SectionType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SectionType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SectionType|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SectionType saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SectionType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SectionType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SectionType findOrCreate($search, callable $callback = null, $options = [])
 */
class SectionTypesTable extends Table
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

        $this->setTable('section_types');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('RoleTypes', [
            'foreignKey' => 'section_type_id'
        ]);
        $this->hasMany('Sections', [
            'foreignKey' => 'section_type_id'
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
            ->scalar('section_type')
            ->maxLength('section_type', 255)
            ->requirePresence('section_type', 'create')
            ->notEmptyString('section_type')
            ->add('section_type', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
        $rules->add($rules->isUnique(['section_type']));

        return $rules;
    }
}

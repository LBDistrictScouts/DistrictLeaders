<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\RoleType;
use App\Model\Entity\Section;
use App\Model\Entity\SectionType;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SectionTypes Model
 *
 * @property \App\Model\Table\RoleTypesTable&\Cake\ORM\Association\HasMany $RoleTypes
 * @property \App\Model\Table\SectionsTable&\Cake\ORM\Association\HasMany $Sections
 * @method \App\Model\Entity\SectionType get($primaryKey, $options = [])
 * @method \App\Model\Entity\SectionType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SectionType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SectionType|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SectionType saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SectionType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SectionType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SectionType findOrCreate($search, callable $callback = null, $options = [])
 * @method \App\Model\Entity\SectionType[]|\Cake\Datasource\ResultSetInterface|false saveMany($entities, $options = [])
 */
class SectionTypesTable extends Table
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

        $this->setTable('section_types');
        $this->setDisplayField(SectionType::FIELD_SECTION_TYPE);
        $this->setPrimaryKey(SectionType::FIELD_ID);

        $this->hasMany('RoleTypes', [
            'foreignKey' => RoleType::FIELD_SECTION_TYPE_ID,
        ]);
        $this->hasMany('Sections', [
            'foreignKey' => Section::FIELD_SECTION_TYPE_ID,
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
            ->integer(SectionType::FIELD_ID)
            ->allowEmptyString(SectionType::FIELD_ID, null, 'create');

        $validator
            ->scalar(SectionType::FIELD_SECTION_TYPE)
            ->maxLength(SectionType::FIELD_SECTION_TYPE, 255)
            ->requirePresence(SectionType::FIELD_SECTION_TYPE, 'create')
            ->notEmptyString(SectionType::FIELD_SECTION_TYPE)
            ->add(SectionType::FIELD_SECTION_TYPE, 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar(SectionType::FIELD_SECTION_TYPE_CODE)
            ->requirePresence(SectionType::FIELD_SECTION_TYPE_CODE, 'create')
            ->maxLength(SectionType::FIELD_SECTION_TYPE_CODE, 1)
            ->notEmptyString(SectionType::FIELD_SECTION_TYPE_CODE);

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
        $rules->add($rules->isUnique([SectionType::FIELD_SECTION_TYPE]));

        return $rules;
    }
}

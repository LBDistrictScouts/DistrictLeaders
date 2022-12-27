<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\RoleType;
use App\Model\Entity\Section;
use App\Model\Entity\SectionType;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Association\HasMany;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SectionTypes Model
 *
 * @property RoleTypesTable&HasMany $RoleTypes
 * @property SectionsTable&HasMany $Sections
 * @method SectionType get($primaryKey, $options = [])
 * @method SectionType newEntity(array $data, array $options = [])
 * @method SectionType[] newEntities(array $data, array $options = [])
 * @method SectionType|false save(EntityInterface $entity, $options = [])
 * @method SectionType saveOrFail(EntityInterface $entity, $options = [])
 * @method SectionType patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method SectionType[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method SectionType findOrCreate($search, ?callable $callback = null, $options = [])
 * @method SectionType[]|ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method SectionType newEmptyEntity()
 * @method SectionType[]|ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method SectionType[]|ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method SectionType[]|ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
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
     * @param Validator $validator Validator instance.
     * @return Validator
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
     * @param RulesChecker $rules The rules object to be modified.
     * @return RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique([SectionType::FIELD_SECTION_TYPE]));

        return $rules;
    }

    /**
     * @param string $sectionType The Section Type for Lookup
     * @param string|null $typeCode The Optional Type Code for Setting
     * @return SectionType
     */
    public function findOrMake(string $sectionType, ?string $typeCode = null): SectionType
    {
        $baseCondition = [SectionType::FIELD_SECTION_TYPE => $sectionType];

        if ($this->exists($baseCondition)) {
            $sectionTypeEntity = $this->find()->where($baseCondition)->first();

            if ($sectionTypeEntity instanceof SectionType) {
                return $sectionTypeEntity;
            }
        }

        if (is_null($typeCode)) {
            $typeCode = substr($sectionType, 0, 1);
        }

        $baseCondition[SectionType::FIELD_SECTION_TYPE_CODE] = $typeCode;

        return $this->findOrCreate($baseCondition);
    }
}

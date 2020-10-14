<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\ScoutGroup;
use App\Model\Entity\Section;
use App\Model\Entity\SectionType;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Sections Model
 *
 * @property \App\Model\Table\SectionTypesTable&\Cake\ORM\Association\BelongsTo $SectionTypes
 * @property \App\Model\Table\ScoutGroupsTable&\Cake\ORM\Association\BelongsTo $ScoutGroups
 * @property \App\Model\Table\RolesTable&\Cake\ORM\Association\HasMany $Roles
 * @method \App\Model\Entity\Section get($primaryKey, $options = [])
 * @method \App\Model\Entity\Section newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Section[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Section|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Section saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Section patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Section[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Section findOrCreate($search, callable $callback = null, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Muffin\Trash\Model\Behavior\TrashBehavior
 * @method \App\Model\Entity\Section[]|\Cake\Datasource\ResultSetInterface|false saveMany($entities, $options = [])
 * @mixin \Expose\Model\Behavior\ExposeBehavior
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsToMany $Users
 * @mixin \Search\Model\Behavior\SearchBehavior
 * @property \App\Model\Table\AuditsTable&\Cake\ORM\Association\HasMany $Audits
 * @mixin \App\Model\Behavior\AuditableBehavior
 */
class SectionsTable extends Table
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

        $this->setTable('sections');
        $this->setDisplayField('section');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Muffin/Trash.Trash');
        $this->addBehavior('Search.Search');
        $this->addBehavior('Expose.Expose', ['on' => 'beforeSave']);

        $this->addBehavior('Auditable', [
            'tracked_fields' => [
                Section::FIELD_SECTION,
                Section::FIELD_MEETING_WEEKDAY,
                Section::FIELD_MEETING_DAY,
                Section::FIELD_SECTION_TYPE_ID,
                Section::FIELD_SCOUT_GROUP_ID,
                Section::FIELD_MEETING_START_TIME,
                Section::FIELD_MEETING_END_TIME,
                Section::FIELD_PUBLIC,
            ],
        ]);

        $this->hasMany('Audits', [
            'foreignKey' => 'audit_record_id',
            'finder' => 'sections',
        ]);

        $this->belongsTo('SectionTypes', [
            'foreignKey' => 'section_type_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ScoutGroups', [
            'foreignKey' => 'scout_group_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Roles', [
            'foreignKey' => 'section_id',
        ]);

        $this->belongsToMany('Users', [
            'through' => 'Roles',
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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('section')
            ->maxLength('section', 255)
            ->requirePresence('section', 'create')
            ->notEmptyString('section')
            ->add('section', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
        $rules->add($rules->isUnique(['section']));
        $rules->add($rules->existsIn(['section_type_id'], 'SectionTypes'));
        $rules->add($rules->existsIn(['scout_group_id'], 'ScoutGroups'));

        return $rules;
    }

    /**
     * @param \Cake\ORM\Query $query The Query to be modified.
     * @return \Cake\ORM\Query
     */
    public function findLeaderSections(Query $query): Query
    {
        return $query
            ->contain(['SectionTypes'])
            ->where(['SectionTypes.' . SectionType::FIELD_SECTION_TYPE_CODE => 'l']);
    }

    /**
     * @param \Cake\ORM\Query $query The Query to be modified.
     * @return \Cake\ORM\Query
     */
    public function findTeamSections(Query $query): Query
    {
        return $query
            ->contain(['SectionTypes'])
            ->where(['SectionTypes.' . SectionType::FIELD_SECTION_TYPE_CODE => 't']);
    }

    /**
     * @param \Cake\ORM\Query $query The Query to be modified.
     * @return \Cake\ORM\Query
     */
    public function findCommitteeSections(Query $query): Query
    {
        return $query
            ->contain(['SectionTypes'])
            ->where(['SectionTypes.' . SectionType::FIELD_SECTION_TYPE_CODE => 'c']);
    }

    /**
     * @param int $scoutGroupId ID of the Scout Group to be created
     * @param int $sectionTypeId ID of the Section Type to be created
     * @return bool
     */
    public function makeStandard(int $scoutGroupId, int $sectionTypeId): bool
    {
        $section = $this->newEmptyEntity();

        $sectionType = $this->SectionTypes->get($sectionTypeId);
        $scoutGroup = $this->ScoutGroups->get($scoutGroupId);

        $section->set(Section::FIELD_SCOUT_GROUP_ID, $scoutGroup->get(ScoutGroup::FIELD_ID));
        $section->set(Section::FIELD_SECTION_TYPE_ID, $sectionType->get(SectionType::FIELD_ID));

        $name = $scoutGroup->group_alias . ' ' . $sectionType->section_type;
        $section->set(Section::FIELD_SECTION, $name);

        return (bool)$this->save($section);
    }

    /**
     * @param string $section Section String
     * @param string $group Group String
     * @param string $sectionType The Section Type for Context
     * @return \App\Model\Entity\Section
     */
    public function findOrMake(string $section, string $group, string $sectionType): Section
    {
        $query = $this->find()->where([Section::FIELD_SECTION => $section]);

        if ($query->count() == 1) {
            $sectionEntity = $query->first();
            if ($sectionEntity instanceof Section) {
                return $sectionEntity;
            }
        }

        $scoutGroup = $this->ScoutGroups->find()
            ->where([ScoutGroup::FIELD_GROUP_ALIAS => $group])
            ->firstOrFail();

        $sectionTypeEntity = $this->SectionTypes->findOrMake($sectionType);

        return $this->findOrCreate([
            Section::FIELD_SECTION => $section,
            Section::FIELD_SCOUT_GROUP_ID => $scoutGroup->id,
            Section::FIELD_SECTION_TYPE_ID => $sectionTypeEntity->id,
        ]);
    }
}

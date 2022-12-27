<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Behavior\AuditableBehavior;
use App\Model\Entity\ScoutGroup;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Association\HasMany;
use Cake\ORM\Behavior\TimestampBehavior;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Expose\Model\Behavior\ExposeBehavior;
use Muffin\Trash\Model\Behavior\TrashBehavior;

/**
 * ScoutGroups Model
 *
 * @property SectionsTable&HasMany $Sections
 * @method ScoutGroup get($primaryKey, $options = [])
 * @method ScoutGroup newEntity(array $data, array $options = [])
 * @method ScoutGroup[] newEntities(array $data, array $options = [])
 * @method ScoutGroup|false save(EntityInterface $entity, $options = [])
 * @method ScoutGroup saveOrFail(EntityInterface $entity, $options = [])
 * @method ScoutGroup patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method ScoutGroup[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method ScoutGroup findOrCreate($search, ?callable $callback = null, $options = [])
 * @mixin TimestampBehavior
 * @mixin TrashBehavior
 * @method ScoutGroup[]|ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @mixin ExposeBehavior
 * @property AuditsTable&HasMany $Audits
 * @mixin AuditableBehavior
 * @property SectionsTable&HasMany $LeaderSections
 * @property SectionsTable&HasMany $CommitteeSections
 * @property SectionsTable&HasMany $TeamSections
 * @method ScoutGroup newEmptyEntity()
 * @method ScoutGroup[]|ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method ScoutGroup[]|ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method ScoutGroup[]|ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @mixin TimestampBehavior
 * @mixin TrashBehavior
 * @mixin ExposeBehavior
 * @mixin AuditableBehavior
 */
class ScoutGroupsTable extends Table
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

        $this->setTable('scout_groups');
        $this->setDisplayField('group_alias');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Muffin/Trash.Trash');
        $this->addBehavior('Expose.Expose', ['on' => 'beforeSave']);

        $this->addBehavior('Auditable', [
            'tracked_fields' => [
                ScoutGroup::FIELD_SCOUT_GROUP,
                ScoutGroup::FIELD_CHARITY_NUMBER,
                ScoutGroup::FIELD_GROUP_DOMAIN,
                ScoutGroup::FIELD_PUBLIC,
            ],
        ]);

        $this->hasMany('Sections', [
            'foreignKey' => 'scout_group_id',
        ]);

        $this->hasMany('LeaderSections', [
            'foreignKey' => 'scout_group_id',
            'className' => 'Sections',
            'finder' => 'leaderSections',
        ]);

        $this->hasMany('CommitteeSections', [
            'foreignKey' => 'scout_group_id',
            'className' => 'Sections',
            'finder' => 'committeeSections',
        ]);

        $this->hasMany('TeamSections', [
            'foreignKey' => 'scout_group_id',
            'className' => 'Sections',
            'finder' => 'teamSections',
        ]);

        $this->hasMany('Audits', [
            'foreignKey' => 'audit_record_id',
            'finder' => 'scoutGroups',
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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('scout_group')
            ->maxLength('scout_group', 255)
            ->requirePresence('scout_group', 'create')
            ->allowEmptyString('scout_group', null, false)
            ->add('scout_group', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('group_alias')
            ->maxLength('group_alias', 30)
            ->allowEmptyString('group_alias');

        $validator
            ->integer('number_stripped')
            ->allowEmptyString('number_stripped');

        $validator
            ->integer('charity_number')
            ->allowEmptyString('charity_number');

        $validator
            ->scalar('group_domain')
            ->maxLength('group_domain', 247)
            ->allowEmptyString('group_domain');

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
        $rules->add($rules->isUnique(['scout_group']));

        return $rules;
    }

    /**
     * A function to Return all the stored Clean Domains. Used for Domain Verification.
     *
     * @return array
     */
    public function getDomains()
    {
        $groups = $this->find('all');
        $cleanDomains = [];

        foreach ($groups as $group) {
            /** @var ScoutGroup $group */
            array_push($cleanDomains, $group->get('clean_domain'));
        }

        return $cleanDomains;
    }

    /**
     * A Loop function to validate an email address against recorded domains.
     *
     * @param string $emailAddress The Email Address to be verified
     * @return bool
     */
    public function domainVerify(string $emailAddress): bool
    {
        $domains = $this->getDomains();
        if (strpos($emailAddress, '@') !== false) {
            $emailDomain = strtolower(explode('@', $emailAddress)[1]);

            return in_array($emailDomain, $domains, true);
        }

        return false;
    }
}

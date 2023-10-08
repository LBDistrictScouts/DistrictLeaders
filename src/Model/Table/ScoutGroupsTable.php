<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\ScoutGroup;
use Cake\Core\Configure;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ScoutGroups Model
 *
 * @property \App\Model\Table\SectionsTable&\App\Model\Table\HasMany $Sections
 * @method \App\Model\Entity\ScoutGroup get($primaryKey, $options = [])
 * @method \App\Model\Entity\ScoutGroup newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ScoutGroup[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ScoutGroup|false save(\App\Model\Table\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ScoutGroup saveOrFail(\App\Model\Table\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ScoutGroup patchEntity(\App\Model\Table\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ScoutGroup[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ScoutGroup findOrCreate($search, ?callable $callback = null, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Muffin\Trash\Model\Behavior\TrashBehavior
 * @method \App\Model\Entity\ScoutGroup[]|\App\Model\Table\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @mixin \Expose\Model\Behavior\ExposeBehavior
 * @property \App\Model\Table\AuditsTable&\App\Model\Table\HasMany $Audits
 * @mixin \App\Model\Behavior\AuditableBehavior
 * @property \App\Model\Table\SectionsTable&\App\Model\Table\HasMany $LeaderSections
 * @property \App\Model\Table\SectionsTable&\App\Model\Table\HasMany $CommitteeSections
 * @property \App\Model\Table\SectionsTable&\App\Model\Table\HasMany $TeamSections
 * @method \App\Model\Entity\ScoutGroup newEmptyEntity()
 * @method \App\Model\Entity\ScoutGroup[]|\App\Model\Table\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ScoutGroup[]|\App\Model\Table\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ScoutGroup[]|\App\Model\Table\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Muffin\Trash\Model\Behavior\TrashBehavior
 * @mixin \Expose\Model\Behavior\ExposeBehavior
 * @mixin \App\Model\Behavior\AuditableBehavior
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
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
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
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
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
    public function getDomains(): array
    {
        $groups = $this->find('all');
        $cleanDomains = [];

        foreach ($groups as $group) {
            /** @var \App\Model\Entity\ScoutGroup $group */
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
        if ($emailAddress == Configure::read('DefaultAdmin.email')) {
            return true;
        }

        $domains = $this->getDomains();
        if (strpos($emailAddress, '@') !== false) {
            $emailDomain = strtolower(explode('@', $emailAddress)[1]);

            return in_array($emailDomain, $domains, true);
        }

        return false;
    }
}

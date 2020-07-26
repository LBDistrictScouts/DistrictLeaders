<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\ScoutGroup;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ScoutGroups Model
 *
 * @property \App\Model\Table\SectionsTable&\Cake\ORM\Association\HasMany $Sections
 * @method \App\Model\Entity\ScoutGroup get($primaryKey, $options = [])
 * @method \App\Model\Entity\ScoutGroup newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ScoutGroup[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ScoutGroup|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ScoutGroup saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ScoutGroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ScoutGroup[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ScoutGroup findOrCreate($search, callable $callback = null, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Muffin\Trash\Model\Behavior\TrashBehavior
 * @method \App\Model\Entity\ScoutGroup[]|\Cake\Datasource\ResultSetInterface|false saveMany($entities, $options = [])
 * @mixin \Expose\Model\Behavior\ExposeBehavior
 * @property \App\Model\Table\AuditsTable&\Cake\ORM\Association\HasMany $Audits
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
    public function getDomains()
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
    public function domainVerify($emailAddress)
    {
        $domains = $this->getDomains();
        if (strpos($emailAddress, '@') !== false) {
            $emailDomain = strtolower(explode('@', $emailAddress)[1]);

            return in_array($emailDomain, $domains, true);
        }

        return false;
    }
}

<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ScoutGroups Model
 *
 * @property \App\Model\Table\SectionsTable|\Cake\ORM\Association\HasMany $Sections
 *
 * @method \App\Model\Entity\ScoutGroup get($primaryKey, $options = [])
 * @method \App\Model\Entity\ScoutGroup newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ScoutGroup[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ScoutGroup|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ScoutGroup saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ScoutGroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ScoutGroup[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ScoutGroup findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ScoutGroupsTable extends Table
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

        $this->setTable('scout_groups');
        $this->setDisplayField('group_alias');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Muffin/Trash.Trash');

        $this->hasMany('Sections', [
            'foreignKey' => 'scout_group_id'
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
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['scout_group']));

        return $rules;
    }
}

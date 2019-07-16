<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CampTypes Model
 *
 * @property \App\Model\Table\CampsTable|\Cake\ORM\Association\HasMany $Camps
 *
 * @method \App\Model\Entity\CampType get($primaryKey, $options = [])
 * @method \App\Model\Entity\CampType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CampType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CampType|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CampType saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CampType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CampType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CampType findOrCreate($search, callable $callback = null, $options = [])
 */
class CampTypesTable extends Table
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

        $this->setTable('camp_types');
        $this->setDisplayField('camp_type');
        $this->setPrimaryKey('id');

        $this->hasMany('Camps', [
            'foreignKey' => 'camp_type_id'
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
            ->scalar('camp_type')
            ->maxLength('camp_type', 30)
            ->requirePresence('camp_type', 'create')
            ->allowEmptyString('camp_type', null, false)
            ->add('camp_type', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
        $rules->add($rules->isUnique(['camp_type']));

        return $rules;
    }
}

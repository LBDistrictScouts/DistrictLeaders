<?php
namespace App\Model\Table;

use App\Model\Entity\CampType;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CampTypes Model
 *
 * @property \App\Model\Table\CampsTable&\Cake\ORM\Association\HasMany $Camps
 *
 * @method CampType get($primaryKey, $options = [])
 * @method CampType newEntity($data = null, array $options = [])
 * @method CampType[] newEntities(array $data, array $options = [])
 * @method CampType|false save(EntityInterface $entity, $options = [])
 * @method CampType saveOrFail(EntityInterface $entity, $options = [])
 * @method CampType patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method CampType[] patchEntities($entities, array $data, array $options = [])
 * @method CampType findOrCreate($search, callable $callback = null, $options = [])
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
            'foreignKey' => 'camp_type_id',
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
            ->notEmptyString('camp_type')
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

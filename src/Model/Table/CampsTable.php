<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Camps Model
 *
 * @property \App\Model\Table\CampTypesTable&\Cake\ORM\Association\BelongsTo $CampTypes
 * @property \App\Model\Table\CampRolesTable&\Cake\ORM\Association\HasMany $CampRoles
 *
 * @method \App\Model\Entity\Camp get($primaryKey, $options = [])
 * @method \App\Model\Entity\Camp newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Camp[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Camp|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Camp saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Camp patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Camp[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Camp findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @method \App\Model\Entity\Camp[]|\Cake\Datasource\ResultSetInterface|false saveMany($entities, $options = [])
 */
class CampsTable extends Table
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

        $this->setTable('camps');
        $this->setDisplayField('camp_name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('CampTypes', [
            'foreignKey' => 'camp_type_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('CampRoles', [
            'foreignKey' => 'camp_id',
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
            ->scalar('camp_name')
            ->maxLength('camp_name', 255)
            ->requirePresence('camp_name', 'create')
            ->notEmptyString('camp_name');

        $validator
            ->dateTime('camp_start')
            ->requirePresence('camp_start', 'create')
            ->allowEmptyDateTime('camp_start', null, false);

        $validator
            ->dateTime('camp_end')
            ->requirePresence('camp_end', 'create')
            ->allowEmptyDateTime('camp_end', null, false);

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
        $rules->add($rules->existsIn(['camp_type_id'], 'CampTypes'));

        return $rules;
    }
}

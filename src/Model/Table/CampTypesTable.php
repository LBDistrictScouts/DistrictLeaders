<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Camp;
use App\Model\Entity\CampType;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Association\HasMany;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CampTypes Model
 *
 * @property CampsTable&HasMany $Camps
 * @method CampType get($primaryKey, $options = [])
 * @method CampType newEntity(array $data, array $options = [])
 * @method CampType[] newEntities(array $data, array $options = [])
 * @method CampType|false save(EntityInterface $entity, $options = [])
 * @method CampType saveOrFail(EntityInterface $entity, $options = [])
 * @method CampType patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method CampType[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method CampType findOrCreate($search, ?callable $callback = null, $options = [])
 * @method CampType[]|ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method CampType newEmptyEntity()
 * @method CampType[]|ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method CampType[]|ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method CampType[]|ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class CampTypesTable extends Table
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

        $this->setTable('camp_types');
        $this->setDisplayField(CampType::FIELD_CAMP_TYPE);
        $this->setPrimaryKey(CampType::FIELD_ID);

        $this->hasMany('Camps', [
            'foreignKey' => Camp::FIELD_CAMP_TYPE_ID,
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
            ->integer(CampType::FIELD_ID)
            ->allowEmptyString(CampType::FIELD_ID, null, 'create');

        $validator
            ->scalar(CampType::FIELD_CAMP_TYPE)
            ->maxLength(CampType::FIELD_CAMP_TYPE, 30)
            ->requirePresence(CampType::FIELD_CAMP_TYPE, 'create')
            ->notEmptyString(CampType::FIELD_CAMP_TYPE)
            ->add(CampType::FIELD_CAMP_TYPE, 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
        $rules->add($rules->isUnique([CampType::FIELD_CAMP_TYPE]));

        return $rules;
    }
}

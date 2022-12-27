<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\EmailResponseType;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Association\HasMany;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmailResponseTypes Model
 *
 * @property EmailResponsesTable&HasMany $EmailResponses
 * @method EmailResponseType get($primaryKey, $options = [])
 * @method EmailResponseType newEntity(array $data, array $options = [])
 * @method EmailResponseType[] newEntities(array $data, array $options = [])
 * @method EmailResponseType|false save(EntityInterface $entity, $options = [])
 * @method EmailResponseType saveOrFail(EntityInterface $entity, $options = [])
 * @method EmailResponseType patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method EmailResponseType[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method EmailResponseType findOrCreate($search, ?callable $callback = null, $options = [])
 * @method EmailResponseType[]|ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method EmailResponseType newEmptyEntity()
 * @method EmailResponseType[]|ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method EmailResponseType[]|ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method EmailResponseType[]|ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class EmailResponseTypesTable extends Table
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

        $this->setTable('email_response_types');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('EmailResponses', [
            'foreignKey' => 'email_response_type_id',
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
            ->scalar('email_response_type')
            ->requirePresence('email_response_type', 'create')
            ->maxLength('email_response_type', 255)
            ->notEmptyString('email_response_type');

        $validator
            ->boolean('bounce')
            ->requirePresence('bounce', 'create')
            ->notEmptyString('bounce');

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
        $rules->add($rules->isUnique(['email_response_type']));

        return $rules;
    }
}

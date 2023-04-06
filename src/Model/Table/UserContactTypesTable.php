<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\UserContactType;
use App\Model\Table\Traits\BaseInstallerTrait;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Association\HasMany;
use Cake\ORM\Behavior\TimestampBehavior;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UserContactTypes Model
 *
 * @property UserContactsTable&HasMany $UserContacts
 * @method UserContactType get($primaryKey, $options = [])
 * @method UserContactType newEntity(array $data, array $options = [])
 * @method UserContactType[] newEntities(array $data, array $options = [])
 * @method UserContactType|false save(EntityInterface $entity, $options = [])
 * @method UserContactType saveOrFail(EntityInterface $entity, $options = [])
 * @method UserContactType patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method UserContactType[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method UserContactType findOrCreate($search, ?callable $callback = null, $options = [])
 * @mixin TimestampBehavior
 * @method UserContactType[]|ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method UserContactType newEmptyEntity()
 * @method UserContactType[]|ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method UserContactType[]|ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method UserContactType[]|ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @mixin TimestampBehavior
 */
class UserContactTypesTable extends Table
{
    use BaseInstallerTrait;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('user_contact_types');
        $this->setDisplayField('user_contact_type');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('UserContacts', [
            'foreignKey' => 'user_contact_type_id',
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
            ->scalar('user_contact_type')
            ->maxLength('user_contact_type', 32)
            ->requirePresence('user_contact_type', 'create')
            ->notEmptyString('user_contact_type')
            ->add('user_contact_type', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
        $rules->add($rules->isUnique(['user_contact_type']));

        return $rules;
    }

    /**
     * install the application status config
     *
     * @return int
     */
    public function installBaseUserContactTypes(): int
    {
        return $this->installBase($this);
    }
}

<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Table\Traits\BaseInstallerTrait;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UserContactTypes Model
 *
 * @property \App\Model\Table\UserContactsTable&\App\Model\Table\HasMany $UserContacts
 * @method \App\Model\Entity\UserContactType get($primaryKey, $options = [])
 * @method \App\Model\Entity\UserContactType newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\UserContactType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UserContactType|false save(\App\Model\Table\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UserContactType saveOrFail(\App\Model\Table\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UserContactType patchEntity(\App\Model\Table\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\UserContactType[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\UserContactType findOrCreate($search, ?callable $callback = null, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @method \App\Model\Entity\UserContactType[]|\App\Model\Table\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\UserContactType newEmptyEntity()
 * @method \App\Model\Entity\UserContactType[]|\App\Model\Table\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\UserContactType[]|\App\Model\Table\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\UserContactType[]|\App\Model\Table\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
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
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
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
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
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

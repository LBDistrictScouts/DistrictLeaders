<?php
namespace App\Model\Table;

use App\Model\Entity\PasswordState;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PasswordStates Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\HasMany $Users
 *
 * @method PasswordState get($primaryKey, $options = [])
 * @method PasswordState newEntity($data = null, array $options = [])
 * @method PasswordState[] newEntities(array $data, array $options = [])
 * @method PasswordState|bool save(EntityInterface $entity, $options = [])
 * @method PasswordState saveOrFail(EntityInterface $entity, $options = [])
 * @method PasswordState patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method PasswordState[] patchEntities($entities, array $data, array $options = [])
 * @method PasswordState findOrCreate($search, callable $callback = null, $options = [])
 */
class PasswordStatesTable extends Table
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

        $this->setTable('password_states');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Users', [
            'foreignKey' => 'password_state_id'
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
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('password_state')
            ->maxLength('password_state', 255)
            ->requirePresence('password_state', 'create')
            ->allowEmptyString('password_state', false);

        $validator
            ->boolean('active')
            ->requirePresence('active', 'create')
            ->allowEmptyString('active', false);

        $validator
            ->boolean('expired')
            ->requirePresence('expired', 'create')
            ->allowEmptyString('expired', false);

        return $validator;
    }
}

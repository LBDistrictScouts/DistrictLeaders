<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\UserState;
use Cake\Core\Configure;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UserStates Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\HasMany $Users
 * @method \App\Model\Entity\UserState get($primaryKey, $options = [])
 * @method \App\Model\Entity\UserState newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\UserState[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UserState|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UserState saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UserState patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\UserState[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\UserState findOrCreate($search, callable $callback = null, $options = [])
 * @method \App\Model\Entity\UserState[]|\Cake\Datasource\ResultSetInterface|false saveMany($entities, $options = [])
 */
class UserStatesTable extends Table
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

        $this->setTable('user_states');
        $this->setDisplayField('user_state');
        $this->setPrimaryKey('id');

        $this->hasMany('Users', [
            'foreignKey' => 'user_state_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): \Cake\Validation\Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('user_state')
            ->maxLength('user_state', 255)
            ->requirePresence('user_state', 'create')
            ->notEmptyString('user_state');

        $validator
            ->boolean('active')
            ->requirePresence('active', 'create')
            ->notEmptyString('active');

        $validator
            ->boolean('expired')
            ->requirePresence('expired', 'create')
            ->notEmptyString('expired');

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
        $rules->add($rules->isUnique(['user_state']));

        return $rules;
    }

    /**
     * install the application status config
     *
     * @return mixed
     */
    public function installBaseUserStates()
    {
        Configure::load('Application' . DS . 'user_states', 'yaml', false);
        $base = Configure::read('userStates');

        $total = 0;

        foreach ($base as $baseState) {
            $query = $this->find()
                ->where([UserState::FIELD_USER_STATE => $baseState[UserState::FIELD_USER_STATE]]);
            $status = $this->newEmptyEntity();
            if ($query->count() > 0) {
                $status = $query->first();
            }
            $this->patchEntity($status, $baseState);
            if ($this->save($status)) {
                $total += 1;
            }
        }

        return $total;
    }
}

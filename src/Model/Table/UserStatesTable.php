<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\User;
use App\Model\Entity\UserState;
use Cake\I18n\FrozenTime;
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
 */
class UserStatesTable extends Table
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

        $this->setTable('user_states');
        $this->setDisplayField(UserState::FIELD_USER_STATE);
        $this->setPrimaryKey(UserState::FIELD_ID);

        $this->hasMany('Users', [
            'foreignKey' => User::FIELD_USER_STATE_ID,
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
            ->integer(UserState::FIELD_ID)
            ->allowEmptyString(UserState::FIELD_ID, null, 'create');

        $validator
            ->scalar(UserState::FIELD_USER_STATE)
            ->maxLength(UserState::FIELD_USER_STATE, 255)
            ->requirePresence(UserState::FIELD_USER_STATE, 'create')
            ->notEmptyString(UserState::FIELD_USER_STATE);

        $validator
            ->boolean(UserState::FIELD_ACTIVE)
            ->requirePresence(UserState::FIELD_ACTIVE, 'create')
            ->notEmptyString(UserState::FIELD_ACTIVE);

        $validator
            ->boolean(UserState::FIELD_EXPIRED)
            ->requirePresence(UserState::FIELD_EXPIRED, 'create')
            ->notEmptyString(UserState::FIELD_EXPIRED);

        $validator
            ->integer(UserState::FIELD_PRECEDENCE_ORDER)
            ->allowEmptyString(UserState::FIELD_PRECEDENCE_ORDER)
            ->add(UserState::FIELD_PRECEDENCE_ORDER, 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->integer(UserState::FIELD_SIGNATURE)
            ->notEmptyString(UserState::FIELD_SIGNATURE);

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
        $rules->add($rules->isUnique([UserState::FIELD_USER_STATE]));
        $rules->add($rules->isUnique([UserState::FIELD_PRECEDENCE_ORDER]));

        return $rules;
    }

    /**
     * install the application status config
     *
     * @return int
     */
    public function installBaseUserStates(): int
    {
        return $this->installBase($this, null, [$this, 'evaluationSignatures'], 'required');
    }

    /**
     * @param \App\Model\Entity\UserState $state The State Object to be enriched
     * @param array $stateData The Data Array to be processed
     * @return \App\Model\Entity\UserState
     */
    public function evaluationSignatures(UserState $state, array $stateData): UserState
    {
        $state->set(UserState::FIELD_SIGNATURE, $this->evaluateSignature($stateData));

        return $state;
    }

    /**
     * @param array $stateData The Data Array to be processed
     * @return int
     */
    public function evaluateSignature(array $stateData): int
    {
        $prefix = UserState::class . '::';
        $signature = 0;

        foreach ($stateData as $evaluation) {
            $result = constant($prefix . $evaluation);
            if (!is_null($result)) {
                $signature |= $result;
            }
        }

        return $signature;
    }

    /**
     * @param \App\Model\Entity\User $user The User to be Evaluated
     * @return int
     */
    public function evaluateUser(User $user): int
    {
        $userEvaluation = 0;

        // Username
        if (!is_null($user->username)) {
            $userEvaluation |= UserState::EVALUATE_USERNAME;
        }

        // Login Ever & Quarter
        if ($user->last_login instanceof FrozenTime) {
            $userEvaluation |= UserState::EVALUATE_LOGIN_EVER;

            if ($user->last_login->diffInMonths(FrozenTime::now()) <= 3) {
                $userEvaluation |= UserState::EVALUATE_LOGIN_QUARTER;
            }
        }

        // Login Capability
        if ($user->checkCapability('LOGIN')) {
            $userEvaluation |= UserState::EVALUATE_LOGIN_CAPABILITY;
        }

        // Active Role
        if ($user->active_role_count > 0) {
            $userEvaluation |= UserState::EVALUATE_ACTIVE_ROLE;
        }

        // Valid Email
        if ($user->validated_email_count > 0) {
            $userEvaluation |= UserState::EVALUATE_VALIDATED_EMAIL;
        }

        return $userEvaluation;
    }
}

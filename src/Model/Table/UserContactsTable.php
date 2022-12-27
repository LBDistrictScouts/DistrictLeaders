<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Behavior\AuditableBehavior;
use App\Model\Behavior\CaseableBehavior;
use App\Model\Entity\User;
use App\Model\Entity\UserContact;
use App\Model\Entity\UserContactType;
use App\Model\Table\Exceptions\BadUserDataException;
use App\Model\Table\Traits\UpdateCounterCacheTrait;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\HasMany;
use Cake\ORM\Behavior\CounterCacheBehavior;
use Cake\ORM\Behavior\TimestampBehavior;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Muffin\Trash\Model\Behavior\TrashBehavior;

/**
 * UserContacts Model
 *
 * @property UsersTable&BelongsTo $Users
 * @property UserContactTypesTable&BelongsTo $UserContactTypes
 * @property RolesTable&HasMany $Roles
 * @method UserContact get($primaryKey, $options = [])
 * @method UserContact newEntity(array $data, array $options = [])
 * @method UserContact[] newEntities(array $data, array $options = [])
 * @method UserContact|false save(EntityInterface $entity, $options = [])
 * @method UserContact saveOrFail(EntityInterface $entity, $options = [])
 * @method UserContact patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method UserContact[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method UserContact findOrCreate($search, ?callable $callback = null, $options = [])
 * @mixin TimestampBehavior
 * @mixin TrashBehavior
 * @property AuditsTable&HasMany $Audits
 * @mixin CaseableBehavior
 * @mixin AuditableBehavior
 * @method UserContact[]|ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @property DirectoryUsersTable&BelongsTo $DirectoryUsers
 * @mixin CounterCacheBehavior
 * @method UserContact newEmptyEntity()
 * @method UserContact[]|ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method UserContact[]|ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method UserContact[]|ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @mixin TimestampBehavior
 * @mixin TrashBehavior
 * @mixin CaseableBehavior
 * @mixin AuditableBehavior
 * @mixin CounterCacheBehavior
 */
class UserContactsTable extends Table
{
    use UpdateCounterCacheTrait;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('user_contacts');
        $this->setDisplayField(UserContact::FIELD_CONTACT_FIELD);
        $this->setPrimaryKey(UserContact::FIELD_ID);

        $this->addBehavior('Timestamp');
        $this->addBehavior('Muffin/Trash.Trash');

        $this->addBehavior('Caseable', [
            'case_columns' => [
                UserContact::FIELD_CONTACT_FIELD => 'l',
            ],
        ]);

        $this->addBehavior('Auditable', [
            'tracked_fields' => [
                UserContact::FIELD_CONTACT_FIELD,
            ],
        ]);

        $this->hasMany('Audits', [
            'foreignKey' => 'audit_record_id',
            'finder' => 'contacts',
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => UserContact::FIELD_USER_ID,
        ]);
        $this->belongsTo('UserContactTypes', [
            'foreignKey' => UserContact::FIELD_USER_CONTACT_TYPE_ID,
        ]);
        $this->belongsTo('DirectoryUsers', [
            'foreignKey' => UserContact::FIELD_DIRECTORY_USER_ID,
        ]);
        $this->hasMany('Roles', [
            'foreignKey' => 'user_contact_id',
        ]);

        $this->addBehavior('CounterCache', [
            'Users' => [
                User::FIELD_ALL_EMAIL_COUNT => [
                    'finder' => 'contactEmails',
                ],
                User::FIELD_ALL_PHONE_COUNT => [
                    'finder' => 'contactNumbers',
                ],
                User::FIELD_VALIDATED_EMAIL_COUNT => [
                    'finder' => 'validatedEmails',
                ],
                User::FIELD_VALIDATED_PHONE_COUNT => [
                    'finder' => 'validatedNumbers',
                ],
            ],
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
            ->integer(UserContact::FIELD_ID)
            ->allowEmptyString(UserContact::FIELD_ID, null, 'create');

        $validator
            ->scalar(UserContact::FIELD_CONTACT_FIELD)
            ->maxLength(UserContact::FIELD_CONTACT_FIELD, 64)
            ->requirePresence(UserContact::FIELD_CONTACT_FIELD, 'create')
            ->notEmptyString(UserContact::FIELD_CONTACT_FIELD);

        $validator
            ->requirePresence(UserContact::FIELD_USER_ID, 'create')
            ->notEmptyString(UserContact::FIELD_USER_ID);

        $validator
            ->requirePresence(UserContact::FIELD_USER_CONTACT_TYPE_ID, 'create')
            ->notEmptyString(UserContact::FIELD_USER_CONTACT_TYPE_ID);

        $validator
            ->boolean(UserContact::FIELD_VERIFIED)
            ->notEmptyString(UserContact::FIELD_VERIFIED);

        return $validator;
    }

    /**
     * Default validation rules.
     *
     * @param Validator $validator Validator instance.
     * @return Validator
     */
    public function validationEmail(Validator $validator)
    {
        $validator = $this->validationDefault($validator);

        $validator
            ->email(UserContact::FIELD_CONTACT_FIELD)
            ->add(UserContact::FIELD_CONTACT_FIELD, 'validDomainEmail', [
                'rule' => 'isValidDomainEmail',
                'message' => __('You must use a Scouting Email Address'),
                'provider' => 'table',
            ]);

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
        $rules->add($rules->existsIn([UserContact::FIELD_USER_ID], 'Users'));
        $rules->add($rules->existsIn([UserContact::FIELD_USER_CONTACT_TYPE_ID], 'UserContactTypes'));
        $rules->add($rules->existsIn([UserContact::FIELD_DIRECTORY_USER_ID], 'DirectoryUsers'));

        $rules->add($rules->isUnique([UserContact::FIELD_USER_ID, UserContact::FIELD_CONTACT_FIELD]));
        $rules->add($rules->isUnique([UserContact::FIELD_CONTACT_FIELD]));

        return $rules;
    }

    /**
     * @param string $value The Entity Value to be validated
     * @param array|null $context The Validation Context
     * @return bool
     */
    public function isValidDomainEmail(string $value, ?array $context = []): bool
    {
        return $this->Users->Roles->Sections->ScoutGroups->domainVerify($value);
    }

    /**
     * @param Query $query The Query to be modified.
     * @return Query
     */
    public function findValidated($query)
    {
        return $query
            ->where([UserContact::FIELD_VERIFIED => true]);
    }

    /**
     * @param Query $query The Query to be modified.
     * @return Query
     */
    public function findContactEmails($query)
    {
        return $query
            ->contain(['UserContactTypes'])
            ->where(['UserContactTypes.user_contact_type' => 'Email']);
    }

    /**
     * @param Query $query The Query to be modified.
     * @return Query
     */
    public function findValidatedEmails($query)
    {
        return $query
            ->find('validated')
            ->find('contactEmails');
    }

    /**
     * @param Query $query The Query to be modified.
     * @return Query
     */
    public function findContactNumbers($query)
    {
        return $query
            ->contain(['UserContactTypes'])
            ->where(['UserContactTypes.user_contact_type' => 'Phone']);
    }

    /**
     * @param Query $query The Query to be modified.
     * @return Query
     */
    public function findValidatedNumbers($query)
    {
        return $query
            ->find('validated')
            ->find('contactNumbers');
    }

    /**
     * @param UserContact $contact The User Contact Email to be made Primary
     * @return bool
     */
    public function makePrimaryEmail(UserContact $contact): bool
    {
        /** @var User $user */
        $user = $this->Users->get($contact->user_id);

        if ($this->isValidDomainEmail($contact->contact_field) && $contact->validated) {
            $user->set(User::FIELD_EMAIL, $contact->contact_field);
            $this->Users->save($user, ['validate' => false]);

            return true;
        }

        return false;
    }

    /**
     * @param UserContact $contact The User Contact Email to be made Primary
     * @return bool
     */
    public function verify(UserContact $contact): bool
    {
        if ($this->isValidDomainEmail($contact->contact_field)) {
            $contact->set(UserContact::FIELD_VERIFIED, true);

            return (bool)($this->save($contact) instanceof UserContact);
        }

        return false;
    }

    /**
     * @param User $user The User for Attaching
     * @param string $email The Email String for Creation
     * @return UserContact
     */
    public function makeEmail(User $user, string $email): UserContact
    {
        if (!$this->isValidDomainEmail($email)) {
            throw new BadUserDataException($email . ' is not a valid Scouting Email.');
        }

        $emailType = $this->UserContactTypes->find()
            ->where([UserContactType::FIELD_USER_CONTACT_TYPE => 'Email'])
            ->first();

        if (!$emailType instanceof UserContactType) {
            throw new RecordNotFoundException();
        }

        return $this->findOrCreate([
            UserContact::FIELD_USER_CONTACT_TYPE_ID => $emailType->id,
            UserContact::FIELD_USER_ID => $user->id,
            UserContact::FIELD_CONTACT_FIELD => $email,
        ]);
    }

    /**
     * @param User $user User to have User Contact Made
     * @return bool
     */
    public function associatePrimary(User $user): bool
    {
        return (bool)($this->makeEmail($user, $user->email) instanceof UserContact);
    }

    /**
     * @param User $user The User for Attaching
     * @param string $number The Phone Number String for Creation
     * @return UserContact
     */
    public function makePhone(User $user, string $number): UserContact
    {
        $numberType = $this->UserContactTypes->find()
            ->where([UserContactType::FIELD_USER_CONTACT_TYPE => 'Phone'])
            ->first();

        if (!$numberType instanceof UserContactType) {
            throw new RecordNotFoundException();
        }

        return $this->findOrCreate([
            UserContact::FIELD_USER_CONTACT_TYPE_ID => $numberType->id,
            UserContact::FIELD_USER_ID => $user->id,
            UserContact::FIELD_CONTACT_FIELD => $number,
        ]);
    }
}

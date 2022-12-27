<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Behavior\AuditableBehavior;
use App\Model\Behavior\CaseableBehavior;
use App\Model\Entity\Audit;
use App\Model\Entity\User;
use Cake\Cache\Cache;
use Cake\Database\Schema\TableSchemaInterface;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\ResultSetInterface;
use Cake\Event\EventInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\BelongsToMany;
use Cake\ORM\Association\HasMany;
use Cake\ORM\Behavior\TimestampBehavior;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Muffin\Trash\Model\Behavior\TrashBehavior;
use Search\Model\Behavior\SearchBehavior;

/**
 * Users Model
 *
 * @property UserStatesTable&BelongsTo $UserStates
 * @property AuditsTable&HasMany $Audits
 * @property AuditsTable&HasMany $Changes
 * @property CampRolesTable&HasMany $CampRoles
 * @property EmailSendsTable&HasMany $EmailSends
 * @property NotificationsTable&HasMany $Notifications
 * @property RolesTable&HasMany $Roles
 * @property UserContactsTable&HasMany $UserContacts
 * @method User get($primaryKey, $options = [])
 * @method User newEntity(array $data, array $options = [])
 * @method User[] newEntities(array $data, array $options = [])
 * @method User|false save(EntityInterface $entity, $options = [])
 * @method User saveOrFail(EntityInterface $entity, $options = [])
 * @method User patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method User[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method User findOrCreate($search, ?callable $callback = null, $options = [])
 * @mixin TimestampBehavior
 * @mixin TrashBehavior
 * @mixin CaseableBehavior
 * @mixin AuditableBehavior
 * @mixin SearchBehavior
 * @method User[]|ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @property DirectoryUsersTable&BelongsToMany $DirectoryUsers
 * @property UserContactsTable&HasMany $ContactEmails
 * @property UserContactsTable&HasMany $ContactNumbers
 * @method User newEmptyEntity()
 * @method User[]|ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method User[]|ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method User[]|ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @mixin TimestampBehavior
 * @mixin TrashBehavior
 * @mixin SearchBehavior
 * @mixin CaseableBehavior
 * @mixin AuditableBehavior
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField(User::FIELD_FULL_NAME);
        $this->setPrimaryKey(User::FIELD_ID);

        $this->addBehavior('Timestamp');
        $this->addBehavior('Muffin/Trash.Trash');
        $this->addBehavior('Search.Search');

        $this->addBehavior('Caseable', [
            'case_columns' => [
                User::FIELD_EMAIL => 'l',
                User::FIELD_POSTCODE => 'u',
                User::FIELD_FIRST_NAME => 'p',
                User::FIELD_LAST_NAME => 'p',
                User::FIELD_ADDRESS_LINE_1 => 't',
                User::FIELD_ADDRESS_LINE_2 => 't',
                User::FIELD_CITY => 't',
                User::FIELD_COUNTY => 't',
            ],
        ]);

        $this->addBehavior('Auditable', [
            'tracked_fields' => [
                User::FIELD_USERNAME,
                User::FIELD_MEMBERSHIP_NUMBER,
                User::FIELD_FIRST_NAME,
                User::FIELD_LAST_NAME,
                User::FIELD_EMAIL,
                User::FIELD_ADDRESS_LINE_1,
                User::FIELD_ADDRESS_LINE_2,
                User::FIELD_CITY,
                User::FIELD_COUNTY,
                User::FIELD_POSTCODE,
            ],
        ]);

        $this->belongsTo('UserStates', [
            'foreignKey' => 'user_state_id',
            'strategy' => 'select',
        ]);

        $this->hasMany('Changes', [
            'className' => 'Audits',
            'foreignKey' => 'user_id',
        ]);

        $this->hasMany('Audits', [
            'foreignKey' => 'audit_record_id',
            'finder' => 'users',
        ]);

        $this->hasMany('CampRoles', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('EmailSends', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Notifications', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Roles', [
            'foreignKey' => 'user_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
        $this->hasMany('UserContacts', [
            'foreignKey' => 'user_id',
        ]);

        $this->hasMany('ContactEmails', [
            'className' => 'UserContacts',
            'foreignKey' => 'user_id',
            'finder' => 'contactEmails',
        ]);

        $this->hasMany('ContactNumbers', [
            'className' => 'UserContacts',
            'foreignKey' => 'user_id',
            'finder' => 'contactNumbers',
        ]);

        $this->belongsToMany('DirectoryUsers', [
            'through' => 'UserContacts',
        ]);
    }

    /**
     * @param TableSchemaInterface $schema The Schema to be modified
     * @return TableSchemaInterface
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _initializeSchema(TableSchemaInterface $schema): TableSchemaInterface
    {
        $schema->setColumnType(User::FIELD_CAPABILITIES, 'json');

        return $schema;
    }

    /**
     * Basic Values required for new user validation rules.
     *
     * @param Validator $validator Validator instance.
     * @return Validator
     */
    public function validationNew(Validator $validator): Validator
    {
        $validator
            ->scalar(User::FIELD_FIRST_NAME)
            ->maxLength(User::FIELD_FIRST_NAME, 255)
            ->requirePresence(User::FIELD_FIRST_NAME, 'create')
            ->notEmptyString(User::FIELD_FIRST_NAME);

        $validator
            ->scalar(User::FIELD_LAST_NAME)
            ->maxLength(User::FIELD_LAST_NAME, 255)
            ->requirePresence(User::FIELD_LAST_NAME, 'create')
            ->notEmptyString(User::FIELD_LAST_NAME);

        $validator
            ->email(User::FIELD_EMAIL)
            ->add(User::FIELD_EMAIL, 'validDomainEmail', [
                'rule' => 'isValidDomainEmail',
                'message' => __('You must use a Scouting Email Address'),
                'provider' => 'table',
            ])
            ->requirePresence(User::FIELD_EMAIL, 'create')
            ->notEmptyString(User::FIELD_EMAIL)
            ->add(User::FIELD_EMAIL, 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->integer(User::FIELD_MEMBERSHIP_NUMBER)
            ->requirePresence(User::FIELD_MEMBERSHIP_NUMBER, 'create')
            ->notEmptyString(User::FIELD_MEMBERSHIP_NUMBER, 'A unique, valid TSA membership number is required.')
            ->add(User::FIELD_MEMBERSHIP_NUMBER, 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        return $validator;
    }

    /**
     * Default validation rules.
     *
     * @param Validator $validator Validator instance.
     * @return Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator = $this->validationNew($validator);

        $validator
            ->integer(User::FIELD_ID)
            ->allowEmptyString(User::FIELD_ID, 'An ID must be set.', 'create');

        $validator
            ->scalar(User::FIELD_USERNAME)
            ->maxLength(User::FIELD_USERNAME, 255)
            ->allowEmptyString(User::FIELD_USERNAME)
            ->add(User::FIELD_USERNAME, 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar(User::FIELD_PASSWORD)
            ->maxLength(User::FIELD_PASSWORD, 255)
            ->allowEmptyString(User::FIELD_PASSWORD);

        $validator
            ->scalar(User::FIELD_ADDRESS_LINE_1)
            ->maxLength(User::FIELD_ADDRESS_LINE_1, 255)
            ->allowEmptyString(User::FIELD_ADDRESS_LINE_1);

        $validator
            ->scalar(User::FIELD_ADDRESS_LINE_2)
            ->maxLength(User::FIELD_ADDRESS_LINE_2, 255)
            ->allowEmptyString(User::FIELD_ADDRESS_LINE_2);

        $validator
            ->scalar(User::FIELD_CITY)
            ->maxLength(User::FIELD_CITY, 255)
            ->allowEmptyString(User::FIELD_CITY);

        $validator
            ->scalar(User::FIELD_COUNTY)
            ->maxLength(User::FIELD_COUNTY, 255)
            ->allowEmptyString(User::FIELD_COUNTY);

        $validator
            ->scalar(User::FIELD_POSTCODE)
            ->maxLength(User::FIELD_POSTCODE, 9)
            ->requirePresence(User::FIELD_POSTCODE, 'create')
            ->notEmptyString(User::FIELD_POSTCODE);

        $validator
            ->dateTime(User::FIELD_LAST_LOGIN)
            ->allowEmptyDateTime(User::FIELD_LAST_LOGIN);

        $validator
            ->scalar(User::FIELD_LAST_LOGIN_IP)
            ->maxLength(User::FIELD_LAST_LOGIN_IP, 255)
            ->allowEmptyString(User::FIELD_LAST_LOGIN_IP);

        $validator
            ->allowEmptyString(User::FIELD_CAPABILITIES);

        $validator
            ->boolean(User::FIELD_COGNITO_ENABLED)
            ->notEmptyString(User::FIELD_COGNITO_ENABLED);

        $validator
            ->boolean(User::FIELD_RECEIVE_EMAILS)
            ->notEmptyString(User::FIELD_RECEIVE_EMAILS);

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
        $rules->add($rules->isUnique([User::FIELD_USERNAME]));
        $rules->add($rules->isUnique([User::FIELD_EMAIL]));
        $rules->add($rules->isUnique([User::FIELD_MEMBERSHIP_NUMBER]));
        $rules->add($rules->existsIn([User::FIELD_USER_STATE_ID], 'UserStates'));

        return $rules;
    }

    /**
     * @param User $user UserEntity
     * @return array
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function retrieveAllCapabilities(User $user)
    {
        $user = $this->get($user->id, [
            'contain' => [
                'Roles' => [
                    'RoleTypes.Capabilities',
                    'Sections.ScoutGroups',
                ],
            ],
        ]);

        $permissions = [];

        $groupPermissions = []; // Group - GroupID
        $sectionPermissions = []; // Section - SectionID

        foreach ($user->roles as $role) {
            $roleType = $role->role_type;

            // Non-specific Capabilities
            if (in_array($roleType->level, [0, 1, 4, 5])) {
                foreach ($roleType->capabilities as $capability) {
                    array_push($permissions, $capability->capability_code);
                }
            }

            // Section capabilities
            if ($roleType->level == 2) {
                foreach ($roleType->capabilities as $capability) {
                    if (! isset($sectionPermissions[$role->section->id])) {
                        $section = [];
                    }
                    if (isset($sectionPermissions[$role->section->id])) {
                        $section = $sectionPermissions[$role->section->id];
                    }
                    if ($capability->min_level > 1) {
                        array_push($section, $capability->capability_code);
                        asort($section);
                        $sectionPermissions[$role->section->id] = $section;
                    }
                    if ($capability->min_level <= 1) {
                        array_push($permissions, $capability->capability_code);
                    }
                }
            }

            // Group capabilities
            if ($roleType->level == 3) {
                foreach ($roleType->capabilities as $capability) {
                    if (! isset($groupPermissions[$role->section->scout_group->id])) {
                        $group = [];
                    }
                    if (isset($groupPermissions[$role->section->scout_group->id])) {
                        $group = $groupPermissions[$role->section->scout_group->id];
                    }
                    if ($capability->min_level > 1) {
                        array_push($group, $capability->capability_code);
                        asort($group);
                        $groupPermissions[$role->section->scout_group->id] = array_unique($group);
                    }
                    if ($capability->min_level <= 1) {
                        array_push($permissions, $capability->capability_code);
                    }
                }
            }
        }

        $userPermissions = [];
        $permissions = array_unique($permissions);

        asort($permissions);
        asort($groupPermissions);
        asort($sectionPermissions);

        $userPermissions[User::CAP_KEY_USER] = $permissions;
        $userPermissions[User::CAP_KEY_GROUP] = $groupPermissions;
        $userPermissions[User::CAP_KEY_SECTION] = $sectionPermissions;

        return $userPermissions;
    }

    /**
     * Retrieve User Capabilities
     *
     * @param User $user The User to have their capabilities Cache Remembered
     * @return array
     */
    public function retrieveCapabilities(User $user)
    {
        return Cache::remember('USR_CAP_' . $user->id, function () use ($user) {
            return $this->retrieveAllCapabilities($user);
        }, 'capability');
    }

    /**
     * Patch User Capabilities
     *
     * @param User $user The User to have their capabilities Cache Remembered
     * @return User|bool
     */
    public function patchCapabilities(User $user)
    {
        $capabilities = $this->retrieveAllCapabilities($user);
        $user->capabilities = $capabilities;
        $user->setDirty('modified', true);

        return $this->save($user);
    }

    /**
     * Check for a User Specific Capability
     *
     * @param User $user The User to be checked
     * @param string $capability The Capability to be found
     * @return bool|array
     */
    public function userCapability(User $user, string $capability)
    {
        $capabilities = $this->retrieveCapabilities($user);

        $userCapabilities = $capabilities[User::CAP_KEY_USER];
        if (in_array($capability, $userCapabilities)) {
            return true;
        }

        $sections = [];
        foreach ($capabilities[User::CAP_KEY_SECTION] as $section => $sectionCapabilities) {
            if (in_array($capability, $sectionCapabilities)) {
                array_push($sections, $section);
            }
        }
        $sections = array_unique($sections);

        $groups = [];
        foreach ($capabilities[User::CAP_KEY_GROUP] as $group => $groupCapabilities) {
            if (in_array($capability, $groupCapabilities)) {
                array_push($groups, $group);
            }
        }
        $groups = array_unique($groups);

        if (!empty($groups) || !empty($sections)) {
            return [
                'sections' => $sections,
                'groups' => $groups,
            ];
        }

        return false;
    }

    /**
     * Finder Method for
     *
     * @param Query $query The Query to be Modified
     * @param array $options The Options passed
     * @return Query
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function findAuth(Query $query, array $options)
    {
        $query
            ->where([User::FIELD_USERNAME . ' IS NOT NULL']);

        return $query;
    }

    /**
     * before Save LifeCycle Callback
     *
     * @param EventInterface $event The Event to be Processed
     * @param User $user The Entity on which the Save is being Called.
     * @param array $options Options Values
     * @return User
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeSave(EventInterface $event, $user, $options): User
    {
        return $this->UserStates->determineUserState($user);
    }

    /**
     * after Save LifeCycle Callback
     *
     * @param EventInterface $event The Event to be Processed
     * @param User $user The Entity on which the Save is being Called.
     * @param array $options Options Values
     * @return User
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterSave(EventInterface $event, $user, $options): User
    {
        $this->UserContacts->associatePrimary($user);

        return $user;
    }

    /**
     * @param string $value The Entity Value to be validated
     * @param array $context The Validation Context
     * @return bool
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function isValidDomainEmail($value, $context)
    {
        return $this->Roles->Sections->ScoutGroups->domainVerify($value);
    }

    /**
     * Function to determine which user created a passed user
     *
     * @param User $user User to be determined
     * @return User|null
     */
    public function determineUserCreator(User $user): ?User
    {
        $userAudit = $this->Audits
            ->find('users')
            ->where([
                Audit::FIELD_AUDIT_RECORD_ID => $user->id,
            ])
            ->contain('Users')
            ->orderAsc(Audit::FIELD_CHANGE_DATE)
            ->first();

        if ($userAudit instanceof Audit && $userAudit->has(Audit::FIELD_USER) && $userAudit->user instanceof User) {
            return $userAudit->user;
        }

        return null;
    }

    /**
     * @param User $user User to be activated
     * @return User
     */
    public function activateUser(User $user): User
    {
        $user->set(User::FIELD_ACTIVATED, true);

        return $this->save($user, ['validate' => false]);
    }
}

<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\Cache\Cache;
use Cake\Database\Schema\TableSchemaInterface;
use Cake\Event\EventInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\UserStatesTable&\Cake\ORM\Association\BelongsTo $UserStates
 * @property \App\Model\Table\AuditsTable&\Cake\ORM\Association\HasMany $Audits
 * @property \App\Model\Table\AuditsTable&\Cake\ORM\Association\HasMany $Changes
 * @property \App\Model\Table\CampRolesTable&\Cake\ORM\Association\HasMany $CampRoles
 * @property \App\Model\Table\EmailSendsTable&\Cake\ORM\Association\HasMany $EmailSends
 * @property \App\Model\Table\NotificationsTable&\Cake\ORM\Association\HasMany $Notifications
 * @property \App\Model\Table\RolesTable&\Cake\ORM\Association\HasMany $Roles
 * @property \App\Model\Table\UserContactsTable&\Cake\ORM\Association\HasMany $UserContacts
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Muffin\Trash\Model\Behavior\TrashBehavior
 * @mixin \App\Model\Behavior\CaseableBehavior
 * @mixin \App\Model\Behavior\AuditableBehavior
 * @mixin \Search\Model\Behavior\SearchBehavior
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false saveMany($entities, $options = [])
 * @property \App\Model\Table\DirectoryUsersTable&\Cake\ORM\Association\BelongsToMany $DirectoryUsers
 * @property \App\Model\Table\UserContactsTable&\Cake\ORM\Association\HasMany $ContactEmails
 * @property \App\Model\Table\UserContactsTable&\Cake\ORM\Association\HasMany $ContactNumbers
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
     * @param \Cake\Database\Schema\TableSchemaInterface $schema The Schema to be modified
     * @return \Cake\Database\Schema\TableSchemaInterface
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
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
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
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
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
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
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
     * @param \App\Model\Entity\User $user UserEntity
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

        $userPermissions['user'] = $permissions;
        $userPermissions['group'] = $groupPermissions;
        $userPermissions['section'] = $sectionPermissions;

        return $userPermissions;
    }

    /**
     * Retrieve User Capabilities
     *
     * @param \App\Model\Entity\User $user The User to have their capabilities Cache Remembered
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
     * @param \App\Model\Entity\User $user The User to have their capabilities Cache Remembered
     * @return \App\Model\Entity\User|bool
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
     * @param \App\Model\Entity\User $user The User to be checked
     * @param string $capability The Capability to be found
     * @return bool|array
     */
    public function userCapability(User $user, string $capability)
    {
        $capabilities = $this->retrieveCapabilities($user);

        $userCapabilities = $capabilities['user'];
        if (in_array($capability, $userCapabilities)) {
            return true;
        }

        $sections = [];
        foreach ($capabilities['section'] as $section => $sectionCapabilities) {
            if (in_array($capability, $sectionCapabilities)) {
                array_push($sections, $section);
            }
        }
        $sections = array_unique($sections);

        $groups = [];
        foreach ($capabilities['group'] as $group => $groupCapabilities) {
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
     * @param \Cake\ORM\Query $query The Query to be Modified
     * @param array $options The Options passed
     * @return \Cake\ORM\Query
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
     * @param \Cake\Event\EventInterface $event The Event to be Processed
     * @param \App\Model\Entity\User $user The Entity on which the Save is being Called.
     * @param array $options Options Values
     * @return \App\Model\Entity\User
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeSave(EventInterface $event, $user, $options): User
    {
        return $this->UserStates->determineUserState($user);
    }

    /**
     * after Save LifeCycle Callback
     *
     * @param \Cake\Event\EventInterface $event The Event to be Processed
     * @param \App\Model\Entity\User $user The Entity on which the Save is being Called.
     * @param array $options Options Values
     * @return \App\Model\Entity\User
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
}

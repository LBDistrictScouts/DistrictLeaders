<?php
namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\Cache\Cache;
use Cake\Database\Schema\TableSchema;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\AuditsTable|\Cake\ORM\Association\HasMany $Audits
 * @property \App\Model\Table\RolesTable|\Cake\ORM\Association\HasMany $Roles
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('username');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Muffin/Trash.Trash');

        $this->hasMany('Audits', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Roles', [
            'foreignKey' => 'user_id'
        ]);
    }

    /**
     * @param TableSchema $schema The Schema to be modified
     *
     * @return TableSchema|\Cake\Database\Schema\TableSchema
     */
    protected function _initializeSchema(TableSchema $schema)
    {
        $schema->setColumnType('capabilities', 'json');

        return $schema;
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
            ->scalar('username')
            ->maxLength('username', 255)
            ->allowEmptyString('username', false)
            ->add('username', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->integer('membership_number')
            ->requirePresence('membership_number', 'create')
            ->allowEmptyString('membership_number', false)
            ->add('membership_number', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('first_name')
            ->maxLength('first_name', 255)
            ->requirePresence('first_name', 'create')
            ->allowEmptyString('first_name', false);

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 255)
            ->requirePresence('last_name', 'create')
            ->allowEmptyString('last_name', false);

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->allowEmptyString('email', false)
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->allowEmptyString('password', false);

        $validator
            ->scalar('address_line_1')
            ->maxLength('address_line_1', 255)
            ->allowEmptyString('address_line_1');

        $validator
            ->scalar('address_line_2')
            ->maxLength('address_line_2', 255)
            ->allowEmptyString('address_line_2');

        $validator
            ->scalar('city')
            ->maxLength('city', 255)
            ->allowEmptyString('city');

        $validator
            ->scalar('county')
            ->maxLength('county', 255)
            ->allowEmptyString('county');

        $validator
            ->scalar('postcode')
            ->maxLength('postcode', 9)
            ->allowEmptyString('postcode');

        $validator
            ->dateTime('last_login')
            ->allowEmptyDateTime('last_login');

        $validator
            ->scalar('last_login_ip')
            ->allowEmptyString('last_login_ip');

        $validator
            ->allowEmptyString('capabilities');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->isUnique(['membership_number']));

        return $rules;
    }

    /**
     * @param User $user UserEntity
     *
     * @return array
     */
    public function retrieveAllCapabilities(User $user)
    {
        $user = $this->get($user->id, [
            'contain' => [
                'Roles' => [
                    'RoleTypes.Capabilities',
                    'Sections.ScoutGroups'
                ]
            ]
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
                        sort($section);
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
                        sort($group);
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
     * @param User $user The User to have their capabilities Cache Remembered
     *
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
     *
     * @return \App\Model\Entity\User|bool
     */
    public function patchCapabilities(User $user)
    {
        $capabilities = $this->retrieveAllCapabilities($user);
        $user->capabilities = $capabilities;

        return $this->save($user);
    }

    /**
     * Check for a User Specific Capability
     *
     * @param User $user The User to be checked
     * @param string $capability The Capability to be found
     *
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
     * @param Query $query The Query to be Modified
     * @param array $options The Options passed
     *
     * @return Query
     */
    public function findAuth(Query $query, array $options)
    {
        $query
            ->where(['username IS NOT NULL']);

        return $query;
    }
}

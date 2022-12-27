<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Behavior\AuditableBehavior;
use App\Model\Entity\Role;
use App\Model\Entity\RoleStatus;
use App\Model\Entity\RoleType;
use App\Model\Entity\User;
use App\Model\Entity\UserContact;
use App\Model\Table\Traits\UpdateCounterCacheTrait;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\ResultSetInterface;
use Cake\Event\Event;
use Cake\Event\EventInterface;
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
 * Roles Model
 *
 * @property RoleTypesTable&BelongsTo $RoleTypes
 * @property SectionsTable&BelongsTo $Sections
 * @property UsersTable&BelongsTo $Users
 * @property RoleStatusesTable&BelongsTo $RoleStatuses
 * @property UserContactsTable&BelongsTo $UserContacts
 * @method Role get($primaryKey, $options = [])
 * @method Role newEntity(array $data, array $options = [])
 * @method Role[] newEntities(array $data, array $options = [])
 * @method Role|false save(EntityInterface $entity, $options = [])
 * @method Role saveOrFail(EntityInterface $entity, $options = [])
 * @method Role patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method Role[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method Role findOrCreate($search, ?callable $callback = null, $options = [])
 * @mixin TimestampBehavior
 * @mixin TrashBehavior
 * @property AuditsTable&HasMany $Audits
 * @method Role[]|ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @mixin CounterCacheBehavior
 * @mixin AuditableBehavior
 * @method Role newEmptyEntity()
 * @method Role[]|ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method Role[]|ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method Role[]|ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class RolesTable extends Table
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

        $this->setTable('roles');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Muffin/Trash.Trash');

        $this->addBehavior('Auditable', [
            'tracked_fields' => [
                Role::FIELD_ROLE_TYPE_ID,
                Role::FIELD_SECTION_ID,
                Role::FIELD_USER_ID,
                Role::FIELD_ROLE_STATUS_ID,
                Role::FIELD_USER_CONTACT_ID,
            ],
        ]);

        $this->hasMany('Audits', [
            'foreignKey' => 'audit_record_id',
            'finder' => 'roles',
        ]);

        $this->belongsTo('RoleTypes', [
            'foreignKey' => 'role_type_id',
        ]);
        $this->belongsTo('Sections', [
            'foreignKey' => 'section_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsTo('RoleStatuses', [
            'foreignKey' => 'role_status_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('UserContacts', [
            'foreignKey' => 'user_contact_id',
        ]);

        $this->addBehavior('CounterCache', [
            'Users' => [
                User::FIELD_ALL_ROLE_COUNT,
                User::FIELD_ACTIVE_ROLE_COUNT => [
                    'finder' => 'active',
                ],
            ],
            'RoleTypes' => [
                RoleType::FIELD_ALL_ROLE_COUNT,
                RoleType::FIELD_ACTIVE_ROLE_COUNT => [
                    'finder' => 'active',
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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->dateTime('deleted')
            ->allowEmptyDateTime('deleted');

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
        $rules->add($rules->existsIn(['role_type_id'], 'RoleTypes'));
        $rules->add($rules->existsIn(['section_id'], 'Sections'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['role_status_id'], 'RoleStatuses'));
        $rules->add($rules->existsIn(['user_contact_id'], 'UserContacts'));

        return $rules;
    }

    /**
     * Finder Method for
     *
     * @param Query $query The Query to be Modified
     * @param array $options The Options passed
     * @return Query
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function findActive(Query $query, array $options)
    {
        $query
            ->contain('RoleStatuses')
            ->where(['RoleStatuses.role_status' => 'Active']);

        return $query;
    }

    /**
     * after Save LifeCycle Callback
     *
     * @param EventInterface $event The Event to be Processed
     * @param Role $role The Entity on which the Save is being Called.
     * @param object|null $options Options Values
     * @return bool
     */
    public function afterSave(EventInterface $event, EntityInterface $role, ?object $options): bool
    {
        $user = $this->Users->get($role->get(Role::FIELD_USER_ID));
        $this->Users->patchCapabilities($user);

        if ($role->isNew()) {
            // Do Task
            $this->getEventManager()->dispatch(new Event(
                'Model.Roles.roleAdded',
                $this,
                ['roleId' => $role->id]
            ));
        } else {
            $this->getEventManager()->dispatch(new Event(
                'Model.Roles.roleUpdated',
                $this,
                ['roleId' => $role->id]
            ));
        }

        return true;
    }

    /**
     * @param User $user The User for Role Creation
     * @param string $section Section for merge
     * @param string $group Group for Section Context
     * @param string $roleType RoleType for merge
     * @param string $sectionType The Section Type
     * @param string|null $status The Role Status
     * @param UserContact|null $userContact The User Contact entity
     * @return bool
     */
    public function mergeRole(
        User $user,
        string $section,
        string $group,
        string $roleType,
        string $sectionType,
        ?string $status = null,
        ?UserContact $userContact = null
    ): bool {
        $sectionEntity = $this->Sections->findOrMake($section, $group, $sectionType);
        $roleTypeEntity = $this->RoleTypes->findOrMake($roleType, $sectionType);

        if (!empty($status)) {
            $status = $this->RoleStatuses->findOrCreate([RoleStatus::FIELD_ROLE_STATUS => $status]);
        } else {
            $status = $this->RoleStatuses->find()->first();
        }

        $newRole = [
            Role::FIELD_USER_ID => $user->id,
            Role::FIELD_ROLE_STATUS_ID => $status->id,
            Role::FIELD_SECTION_ID => $sectionEntity->id,
            Role::FIELD_ROLE_TYPE_ID => $roleTypeEntity->id,
        ];

        if (!empty($userContact)) {
            $newRole[Role::FIELD_USER_CONTACT_ID] = $userContact->id;
        }

        return (bool)($this->findOrCreate($newRole) instanceof Role);
    }
}

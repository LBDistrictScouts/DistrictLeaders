<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Role;
use App\Model\Entity\RoleStatus;
use App\Model\Entity\RoleType;
use App\Model\Entity\User;
use App\Model\Entity\UserContact;
use App\Model\Table\Traits\UpdateCounterCacheTrait;
use Cake\Event\Event;
use Cake\Event\EventInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Roles Model
 *
 * @property \App\Model\Table\RoleTypesTable&\Cake\ORM\Association\BelongsTo $RoleTypes
 * @property \App\Model\Table\SectionsTable&\Cake\ORM\Association\BelongsTo $Sections
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\RoleStatusesTable&\Cake\ORM\Association\BelongsTo $RoleStatuses
 * @property \App\Model\Table\UserContactsTable&\Cake\ORM\Association\BelongsTo $UserContacts
 * @method \App\Model\Entity\Role get($primaryKey, $options = [])
 * @method \App\Model\Entity\Role newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Role[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Role|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Role saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Role patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Role[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Role findOrCreate($search, callable $callback = null, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Muffin\Trash\Model\Behavior\TrashBehavior
 * @property \App\Model\Table\AuditsTable&\Cake\ORM\Association\HasMany $Audits
 * @method \App\Model\Entity\Role[]|\Cake\Datasource\ResultSetInterface|false saveMany($entities, $options = [])
 * @mixin \Cake\ORM\Behavior\CounterCacheBehavior
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
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
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
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
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
     * @param \Cake\ORM\Query $query The Query to be Modified
     * @param array $options The Options passed
     * @return \Cake\ORM\Query
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
     * @param \Cake\Event\EventInterface $event The Event to be Processed
     * @param \App\Model\Entity\Role $entity The Entity on which the Save is being Called.
     * @param array $options Options Values
     * @return bool
     */
    public function afterSave(EventInterface $event, $entity, $options)
    {
        $user = $this->Users->get($entity->get(Role::FIELD_USER_ID));
        $this->Users->patchCapabilities($user);

        if ($entity->isNew()) {
            // Do Task
            $this->getEventManager()->dispatch(new Event(
                'Model.Role.roleAdded',
                $this,
                ['role' => $entity]
            ));
        }

        $dirtyValues = $entity->getDirty();

        $trackedFields = [
            'role_type_id',
            'section_id',
            'user_id',
            'role_status_id',
            'user_contact_id',
        ];

        $auditCount = 0;

        foreach ($dirtyValues as $dirty_value) {
            if (in_array($dirty_value, $trackedFields)) {
                $current = $entity->get($dirty_value);
                $original = $entity->getOriginal($dirty_value);

                if ($entity->isNew()) {
                    $original = null;
                }

                if ($current <> $original) {
                    $auditData = [
                        'audit_record_id' => $entity->get('id'),
                        'audit_field' => $dirty_value,
                        'audit_table' => 'Roles',
                        'original_value' => $original,
                        'modified_value' => $current,
                    ];

                    $audit = $this->Users->Audits->newEntity($auditData);
                    $this->Users->Audits->save($audit);
                    $auditCount += 1;
                }
            }
        }

        if ($auditCount > 0 && !$entity->isNew()) {
            $this->getEventManager()->dispatch(new Event(
                'Model.Role.newAudits',
                $this,
                [
                    'role' => $entity,
                    'count' => $auditCount,
                ]
            ));
        }

        return true;
    }

    /**
     * @param \App\Model\Entity\User $user The User for Role Creation
     * @param string $section Section for merge
     * @param string $group Group for Section Context
     * @param string $roleType RoleType for merge
     * @param string $sectionType The Section Type
     * @param string|null $status The Role Status
     * @param \App\Model\Entity\UserContact|null $userContact The User Contact entity
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

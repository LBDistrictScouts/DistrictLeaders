<?php
namespace App\Model\Table;

use App\Model\Entity\Role;
use App\Model\Entity\User;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Roles Model
 *
 * @property \App\Model\Table\RoleTypesTable&\Cake\ORM\Association\BelongsTo $RoleTypes
 * @property \App\Model\Table\SectionsTable&\Cake\ORM\Association\BelongsTo $Sections
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\RoleStatusesTable&\Cake\ORM\Association\BelongsTo $RoleStatuses
 * @property \App\Model\Table\UserContactsTable&\Cake\ORM\Association\BelongsTo $UserContacts
 *
 * @method Role get($primaryKey, $options = [])
 * @method Role newEntity($data = null, array $options = [])
 * @method Role[] newEntities(array $data, array $options = [])
 * @method Role|false save(EntityInterface $entity, $options = [])
 * @method Role saveOrFail(EntityInterface $entity, $options = [])
 * @method Role patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method Role[] patchEntities($entities, array $data, array $options = [])
 * @method Role findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Muffin\Trash\Model\Behavior\TrashBehavior
 * @property \App\Model\Table\AuditsTable&\Cake\ORM\Association\HasMany $Audits
 */
class RolesTable extends Table
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
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Sections', [
            'foreignKey' => 'section_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('RoleStatuses', [
            'foreignKey' => 'role_status_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('UserContacts', [
            'foreignKey' => 'user_contact_id',
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
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['role_type_id'], 'RoleTypes'));
        $rules->add($rules->existsIn(['section_id'], 'Sections'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['role_status_id'], 'RoleStatuses'));
        $rules->add($rules->existsIn(['user_contact_id'], 'UserContacts'));

        return $rules;
    }

    /**
     * after Save LifeCycle Callback
     *
     * @param \Cake\Event\Event $event The Event to be Processed
     * @param Role $entity The Entity on which the Save is being Called.
     * @param array $options Options Values
     *
     * @return bool
     */
    public function afterSave($event, $entity, $options)
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
}

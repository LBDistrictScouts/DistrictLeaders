<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Audits Model
 *
 * @property \App\Model\Table\UsersTable&\App\Model\Table\BelongsTo $Users
 * @property \App\Model\Table\UsersTable&\App\Model\Table\BelongsTo $ChangedUsers
 * @method \App\Model\Entity\Audit get($primaryKey, $options = [])
 * @method \App\Model\Entity\Audit newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Audit[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Audit|false save(\App\Model\Table\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Audit saveOrFail(\App\Model\Table\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Audit patchEntity(\App\Model\Table\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Audit[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Audit findOrCreate($search, ?callable $callback = null, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Muffin\Footprint\Model\Behavior\FootprintBehavior
 * @method \App\Model\Entity\Audit[]|\App\Model\Table\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @property \App\Model\Table\RolesTable&\App\Model\Table\BelongsTo $ChangedRoles
 * @property \App\Model\Table\ScoutGroupsTable&\App\Model\Table\BelongsTo $ChangedScoutGroups
 * @property \App\Model\Table\UserContactsTable&\App\Model\Table\BelongsTo $ChangedUserContacts
 * @property \App\Model\Table\SectionsTable&\App\Model\Table\BelongsTo $ChangedSections
 * @property \App\Model\Table\SectionsTable&\App\Model\Table\BelongsTo $NewSections
 * @property \App\Model\Table\RoleTypesTable&\App\Model\Table\BelongsTo $NewRoleTypes
 * @property \App\Model\Table\UsersTable&\App\Model\Table\BelongsTo $NewUsers
 * @property \App\Model\Table\RoleStatusesTable&\App\Model\Table\BelongsTo $NewRoleStatuses
 * @property \App\Model\Table\UserContactsTable&\App\Model\Table\BelongsTo $NewUserContacts
 * @property \App\Model\Table\SectionsTable&\App\Model\Table\BelongsTo $OriginalSections
 * @property \App\Model\Table\RoleTypesTable&\App\Model\Table\BelongsTo $OriginalRoleTypes
 * @property \App\Model\Table\UsersTable&\App\Model\Table\BelongsTo $OriginalUsers
 * @property \App\Model\Table\RoleStatusesTable&\App\Model\Table\BelongsTo $OriginalRoleStatuses
 * @property \App\Model\Table\UserContactsTable&\App\Model\Table\BelongsTo $OriginalUserContacts
 * @method \App\Model\Entity\Audit newEmptyEntity()
 * @method \App\Model\Entity\Audit[]|\App\Model\Table\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Audit[]|\App\Model\Table\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Audit[]|\App\Model\Table\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Muffin\Footprint\Model\Behavior\FootprintBehavior
 */
class AuditsTable extends Table
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

        $this->setTable('audits');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'change_date' => 'new',
                ],
            ],
        ]);

        $this->addBehavior('Muffin/Footprint.Footprint', [
            'events' => [
                'Model.afterSave' => [
                    'user_id' => 'always',
                ],
                'Model.beforeSave' => [
                    'user_id' => 'always',
                ],
            ],
            'propertiesMap' => [
                'user_id' => '_footprint.id',
            ],
        ]);

        $this->belongsTo('ChangedUsers', [
            'className' => 'Users',
            'foreignKey' => 'audit_record_id',
            'strategy' => 'join',
            'conditions' => [
                'audit_table' => 'Users',
            ],
            'finder' => 'withTrashed',
        ]);

        $this->belongsTo('ChangedRoles', [
            'className' => 'Roles',
            'foreignKey' => 'audit_record_id',
            'strategy' => 'join',
            'conditions' => [
                'audit_table' => 'Roles',
            ],
            'finder' => 'withTrashed',
        ]);

        $this->belongsTo('ChangedUserContacts', [
            'className' => 'UserContacts',
            'foreignKey' => 'audit_record_id',
            'strategy' => 'join',
            'conditions' => [
                'audit_table' => 'UserContacts',
            ],
            'finder' => 'withTrashed',
        ]);

        $this->belongsTo('ChangedScoutGroups', [
            'className' => 'ScoutGroups',
            'foreignKey' => 'audit_record_id',
            'strategy' => 'join',
            'conditions' => [
                'audit_table' => 'ScoutGroups',
            ],
            'finder' => 'withTrashed',
        ]);

        $this->belongsTo('ChangedSections', [
            'className' => 'Sections',
            'foreignKey' => 'audit_record_id',
            'strategy' => 'join',
            'conditions' => [
                'audit_table' => 'Sections',
            ],
            'finder' => 'withTrashed',
        ]);

        // Modified / New Values

        $this->belongsTo('NewSections', [
            'className' => 'Sections',
            'propertyName' => 'new_section',
            'foreignKey' => 'modified_value',
            'strategy' => 'select',
            'finder' => 'withTrashed',
        ]);

        $this->belongsTo('NewRoleTypes', [
            'className' => 'RoleTypes',
            'propertyName' => 'new_role_type',
            'foreignKey' => 'modified_value',
            'strategy' => 'select',
        ]);

        $this->belongsTo('NewUsers', [
            'className' => 'Users',
            'propertyName' => 'new_user',
            'foreignKey' => 'modified_value',
            'strategy' => 'select',
            'finder' => 'withTrashed',
        ]);

        $this->belongsTo('NewRoleStatuses', [
            'className' => 'RoleStatuses',
            'propertyName' => 'new_role_status',
            'foreignKey' => 'modified_value',
            'strategy' => 'select',
        ]);

        $this->belongsTo('NewUserContacts', [
            'className' => 'UserContacts',
            'propertyName' => 'new_user_contact',
            'foreignKey' => 'modified_value',
            'strategy' => 'select',
            'finder' => 'withTrashed',
        ]);

        // Original Values

        $this->belongsTo('OriginalSections', [
            'className' => 'Sections',
            'propertyName' => 'original_section',
            'foreignKey' => 'original_value',
            'strategy' => 'select',
            'finder' => 'withTrashed',
        ]);

        $this->belongsTo('OriginalRoleTypes', [
            'className' => 'RoleTypes',
            'propertyName' => 'original_role_type',
            'foreignKey' => 'original_value',
            'strategy' => 'select',
        ]);

        $this->belongsTo('OriginalUsers', [
            'className' => 'Users',
            'propertyName' => 'original_user',
            'foreignKey' => 'original_value',
            'strategy' => 'select',
            'finder' => 'withTrashed',
        ]);

        $this->belongsTo('OriginalRoleStatuses', [
            'className' => 'RoleStatuses',
            'propertyName' => 'original_role_status',
            'foreignKey' => 'original_value',
            'strategy' => 'select',
        ]);

        $this->belongsTo('OriginalUserContacts', [
            'className' => 'UserContacts',
            'propertyName' => 'original_user_contact',
            'foreignKey' => 'original_value',
            'strategy' => 'select',
            'finder' => 'withTrashed',
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
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
            ->scalar('audit_field')
            ->maxLength('audit_field', 255)
            ->requirePresence('audit_field', 'create')
            ->notEmptyString('audit_field');

        $validator
            ->scalar('audit_table')
            ->maxLength('audit_table', 255)
            ->requirePresence('audit_table', 'create')
            ->notEmptyString('audit_table');

        $validator
            ->integer('audit_record_id')
            ->requirePresence('audit_record_id', 'create')
            ->notEmptyString('audit_record_id');

        $validator
            ->scalar('original_value')
            ->maxLength('original_value', 255)
            ->allowEmptyString('original_value');

        $validator
            ->scalar('modified_value')
            ->maxLength('modified_value', 255)
            ->requirePresence('modified_value', 'create')
            ->notEmptyString('modified_value');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }

    /**
     * @param \Cake\ORM\Query $query The Query to be modified.
     * @return \Cake\ORM\Query
     */
    public function findUsers(Query $query): Query
    {
        $query->where(['audit_table' => 'Users']);

        return $query;
    }

    /**
     * @param \Cake\ORM\Query $query The Query to be modified.
     * @return \Cake\ORM\Query
     */
    public function findRoles(Query $query): Query
    {
        $query->where(['audit_table' => 'Roles']);

        return $query;
    }

    /**
     * @param \Cake\ORM\Query $query The Query to be modified.
     * @return \Cake\ORM\Query
     */
    public function findScoutGroups(Query $query): Query
    {
        $query->where(['audit_table' => 'ScoutGroups']);

        return $query;
    }

    /**
     * @param \Cake\ORM\Query $query The Query to be modified.
     * @return \Cake\ORM\Query
     */
    public function findSections(Query $query): Query
    {
        $query->where(['audit_table' => 'Sections']);

        return $query;
    }

    /**
     * @param \Cake\ORM\Query $query The Query to be modified.
     * @return \Cake\ORM\Query
     */
    public function findContacts(Query $query): Query
    {
        $query->where(['audit_table' => 'UserContacts']);

        return $query;
    }
}

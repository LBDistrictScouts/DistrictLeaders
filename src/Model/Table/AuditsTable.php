<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Audit;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Behavior\TimestampBehavior;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Muffin\Footprint\Model\Behavior\FootprintBehavior;

/**
 * Audits Model
 *
 * @property UsersTable&BelongsTo $Users
 * @property UsersTable&BelongsTo $ChangedUsers
 * @method Audit get($primaryKey, $options = [])
 * @method Audit newEntity(array $data, array $options = [])
 * @method Audit[] newEntities(array $data, array $options = [])
 * @method Audit|false save(EntityInterface $entity, $options = [])
 * @method Audit saveOrFail(EntityInterface $entity, $options = [])
 * @method Audit patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method Audit[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method Audit findOrCreate($search, ?callable $callback = null, $options = [])
 * @mixin TimestampBehavior
 * @mixin FootprintBehavior
 * @method Audit[]|ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @property RolesTable&BelongsTo $ChangedRoles
 * @property ScoutGroupsTable&BelongsTo $ChangedScoutGroups
 * @property UserContactsTable&BelongsTo $ChangedUserContacts
 * @property SectionsTable&BelongsTo $ChangedSections
 * @property SectionsTable&BelongsTo $NewSections
 * @property RoleTypesTable&BelongsTo $NewRoleTypes
 * @property UsersTable&BelongsTo $NewUsers
 * @property RoleStatusesTable&BelongsTo $NewRoleStatuses
 * @property UserContactsTable&BelongsTo $NewUserContacts
 * @property SectionsTable&BelongsTo $OriginalSections
 * @property RoleTypesTable&BelongsTo $OriginalRoleTypes
 * @property UsersTable&BelongsTo $OriginalUsers
 * @property RoleStatusesTable&BelongsTo $OriginalRoleStatuses
 * @property UserContactsTable&BelongsTo $OriginalUserContacts
 * @method Audit newEmptyEntity()
 * @method Audit[]|ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method Audit[]|ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method Audit[]|ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @mixin TimestampBehavior
 * @mixin FootprintBehavior
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
     * @param Validator $validator Validator instance.
     * @return Validator
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
     * @param RulesChecker $rules The rules object to be modified.
     * @return RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }

    /**
     * @param Query $query The Query to be modified.
     * @return Query
     */
    public function findUsers(Query $query): Query
    {
        $query->where(['audit_table' => 'Users']);

        return $query;
    }

    /**
     * @param Query $query The Query to be modified.
     * @return Query
     */
    public function findRoles(Query $query): Query
    {
        $query->where(['audit_table' => 'Roles']);

        return $query;
    }

    /**
     * @param Query $query The Query to be modified.
     * @return Query
     */
    public function findScoutGroups(Query $query): Query
    {
        $query->where(['audit_table' => 'ScoutGroups']);

        return $query;
    }

    /**
     * @param Query $query The Query to be modified.
     * @return Query
     */
    public function findSections(Query $query): Query
    {
        $query->where(['audit_table' => 'Sections']);

        return $query;
    }

    /**
     * @param Query $query The Query to be modified.
     * @return Query
     */
    public function findContacts(Query $query): Query
    {
        $query->where(['audit_table' => 'UserContacts']);

        return $query;
    }
}

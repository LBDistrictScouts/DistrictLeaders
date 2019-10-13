<?php
namespace App\Model\Table;

use App\Model\Entity\UserContact;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UserContacts Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\UserContactTypesTable&\Cake\ORM\Association\BelongsTo $UserContactTypes
 * @property \App\Model\Table\RolesTable&\Cake\ORM\Association\HasMany $Roles
 *
 * @method UserContact get($primaryKey, $options = [])
 * @method UserContact newEntity($data = null, array $options = [])
 * @method UserContact[] newEntities(array $data, array $options = [])
 * @method UserContact|false save(EntityInterface $entity, $options = [])
 * @method UserContact saveOrFail(EntityInterface $entity, $options = [])
 * @method UserContact patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method UserContact[] patchEntities($entities, array $data, array $options = [])
 * @method UserContact findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Muffin\Trash\Model\Behavior\TrashBehavior
 * @property \App\Model\Table\AuditsTable&\Cake\ORM\Association\HasMany $Audits
 * @mixin \App\Model\Behavior\CaseableBehavior
 * @mixin \App\Model\Behavior\AuditableBehavior
 */
class UserContactsTable extends Table
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

        $this->setTable('user_contacts');
        $this->setDisplayField('contact_field');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Muffin/Trash.Trash');

        $this->addBehavior('Caseable', [
            'case_columns' => [
                'contact_field' => 'l',
            ]
        ]);

        $this->addBehavior('Auditable', [
            'tracked_fields' => [
                'contact_field'
            ]
        ]);

        $this->hasMany('Audits', [
            'foreignKey' => 'audit_record_id',
            'finder' => 'contacts',
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('UserContactTypes', [
            'foreignKey' => 'user_contact_type_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Roles', [
            'foreignKey' => 'user_contact_id'
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
            ->scalar('contact_field')
            ->maxLength('contact_field', 64)
            ->requirePresence('contact_field', 'create')
            ->notEmptyString('contact_field');

        $validator
            ->requirePresence('user_id', 'create')
            ->notEmptyString('user_id', 'create');

        $validator
            ->requirePresence('user_contact_type_id', 'create')
            ->notEmptyString('user_contact_type_id', 'create');

        $validator
            ->boolean('verified')
            ->notEmptyString('verified');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['user_contact_type_id'], 'UserContactTypes'));

        $rules->add($rules->isUnique(['user_id', 'contact_field']));

        return $rules;
    }
}

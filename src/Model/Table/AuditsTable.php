<?php
namespace App\Model\Table;

use App\Model\Entity\Audit;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Audits Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $ChangedUsers
 *
 * @method Audit get($primaryKey, $options = [])
 * @method Audit newEntity($data = null, array $options = [])
 * @method Audit[] newEntities(array $data, array $options = [])
 * @method Audit|false save(EntityInterface $entity, $options = [])
 * @method Audit saveOrFail(EntityInterface $entity, $options = [])
 * @method Audit patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method Audit[] patchEntities($entities, array $data, array $options = [])
 * @method Audit findOrCreate($search, callable $callback = null, $options = [])
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
    public function initialize(array $config)
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
            ]
        ]);

        $this->addBehavior('Muffin/Footprint.Footprint', [
            'events' => [
                'Model.afterSave' => [
                    'user_id' => 'always',
                ],
                'Model.beforeSave' => [
                    'user_id' => 'always',
                ]
            ],
            'propertiesMap' => [
                'user_id' => '_footprint.id',
            ],
        ]);

        $this->belongsTo('ChangedUsers', [
            'className' => 'Users',
            'foreignKey' => 'audit_record_id',
            'strategy' => 'select',
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
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
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }

    /**
     * @param Query $query The Query to be modified.
     *
     * @return Query
     */
    public function findUsers($query)
    {
        $query->where(['audit_table' => 'Users']);

        return $query;
    }

    /**
     * @param Query $query The Query to be modified.
     *
     * @return Query
     */
    public function findRoles($query)
    {
        $query->where(['audit_table' => 'Roles']);

        return $query;
    }

    /**
     * @param Query $query The Query to be modified.
     *
     * @return Query
     */
    public function findContacts($query)
    {
        $query->where(['audit_table' => 'UserContacts']);

        return $query;
    }
}

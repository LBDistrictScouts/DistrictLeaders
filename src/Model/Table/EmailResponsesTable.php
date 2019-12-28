<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmailResponses Model
 *
 * @property \App\Model\Table\EmailSendsTable&\Cake\ORM\Association\BelongsTo $EmailSends
 * @property \App\Model\Table\EmailResponseTypesTable&\Cake\ORM\Association\BelongsTo $EmailResponseTypes
 *
 * @method \App\Model\Entity\EmailResponse get($primaryKey, $options = [])
 * @method \App\Model\Entity\EmailResponse newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EmailResponse[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmailResponse|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmailResponse saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmailResponse patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EmailResponse[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmailResponse findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Muffin\Trash\Model\Behavior\TrashBehavior
 */
class EmailResponsesTable extends Table
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

        $this->setTable('email_responses');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'modified' => 'always',
                ],
            ],
        ]);

        $this->addBehavior('Muffin/Trash.Trash', [
            'field' => 'deleted',
        ]);

        $this->belongsTo('EmailSends', [
            'foreignKey' => 'email_send_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('EmailResponseTypes', [
            'foreignKey' => 'email_response_type_id',
            'joinType' => 'INNER',
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
            ->integer('email_send_id')
            ->requirePresence('email_send_id')
            ->notEmptyString('email_send_id');

        $validator
            ->integer('email_response_type_id')
            ->requirePresence('email_response_type_id')
            ->notEmptyString('email_response_type_id');

        $validator
            ->dateTime('received')
            ->notEmptyDateTime('received');

        $validator
            ->scalar('link_clicked')
            ->maxLength('link_clicked', 511)
            ->allowEmptyString('link_clicked');

        $validator
            ->scalar('ip_address')
            ->maxLength('ip_address', 255)
            ->allowEmptyString('ip_address');

        $validator
            ->scalar('bounce_reason')
            ->maxLength('bounce_reason', 511)
            ->allowEmptyString('bounce_reason');

        $validator
            ->integer('message_size')
            ->allowEmptyString('message_size');

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
        $rules->add($rules->existsIn(['email_send_id'], 'EmailSends'));
        $rules->add($rules->existsIn(['email_response_type_id'], 'EmailResponseTypes'));

        return $rules;
    }
}

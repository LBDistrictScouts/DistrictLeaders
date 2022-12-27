<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\EmailResponse;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Behavior\TimestampBehavior;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Muffin\Trash\Model\Behavior\TrashBehavior;

/**
 * EmailResponses Model
 *
 * @property EmailSendsTable&BelongsTo $EmailSends
 * @property EmailResponseTypesTable&BelongsTo $EmailResponseTypes
 * @method EmailResponse get($primaryKey, $options = [])
 * @method EmailResponse newEntity(array $data, array $options = [])
 * @method EmailResponse[] newEntities(array $data, array $options = [])
 * @method EmailResponse|false save(EntityInterface $entity, $options = [])
 * @method EmailResponse saveOrFail(EntityInterface $entity, $options = [])
 * @method EmailResponse patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method EmailResponse[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method EmailResponse findOrCreate($search, ?callable $callback = null, $options = [])
 * @mixin TimestampBehavior
 * @mixin TrashBehavior
 * @method EmailResponse[]|ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method EmailResponse newEmptyEntity()
 * @method EmailResponse[]|ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method EmailResponse[]|ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method EmailResponse[]|ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @mixin TimestampBehavior
 * @mixin TrashBehavior
 */
class EmailResponsesTable extends Table
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
     * @param Validator $validator Validator instance.
     * @return Validator
     */
    public function validationDefault(Validator $validator): Validator
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
     * @param RulesChecker $rules The rules object to be modified.
     * @return RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['email_send_id'], 'EmailSends'));
        $rules->add($rules->existsIn(['email_response_type_id'], 'EmailResponseTypes'));

        return $rules;
    }
}

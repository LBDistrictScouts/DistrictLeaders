<?php
namespace App\Model\Table;

use App\Model\Entity\Token;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tokens Model
 *
 * @property \App\Model\Table\EmailSendsTable&\Cake\ORM\Association\BelongsTo $EmailSends
 *
 * @method \App\Model\Entity\Token get($primaryKey, $options = [])
 * @method \App\Model\Entity\Token newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Token[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Token|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Token saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Token patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Token[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Token findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TokensTable extends Table
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

        $this->setTable('tokens');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('EmailSends', [
            'foreignKey' => 'email_send_id',
            'joinType' => 'INNER'
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
            ->scalar('token')
            ->maxLength('token', 511)
            ->requirePresence('token', 'create')
            ->notEmptyString('token');

        $validator
            ->dateTime('expires')
            ->allowEmptyDateTime('expires');

        $validator
            ->dateTime('utilised')
            ->allowEmptyDateTime('utilised');

        $validator
            ->boolean('active')
            ->notEmptyString('active');

        $validator
            ->dateTime('deleted')
            ->allowEmptyDateTime('deleted');

        $validator
            ->scalar('hash')
            ->maxLength('hash', 511)
            ->allowEmptyString('hash');

        $validator
            ->integer('random_number')
            ->allowEmptyString('random_number');

        $validator
            ->allowEmptyString('token_header');

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

        return $rules;
    }
}

<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SiteSessions Model
 *
 * @method \App\Model\Entity\SiteSession get($primaryKey, $options = [])
 * @method \App\Model\Entity\SiteSession newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\SiteSession[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SiteSession|false save(\App\Model\Table\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SiteSession saveOrFail(\App\Model\Table\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SiteSession patchEntity(\App\Model\Table\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SiteSession[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\SiteSession findOrCreate($search, ?callable $callback = null, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @method \App\Model\Entity\SiteSession[]|\App\Model\Table\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\SiteSession newEmptyEntity()
 * @method \App\Model\Entity\SiteSession[]|\App\Model\Table\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\SiteSession[]|\App\Model\Table\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\SiteSession[]|\App\Model\Table\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SiteSessionsTable extends Table
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

        $this->setTable('site_sessions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->scalar('id')
            ->maxLength('id', 40)
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('data')
            ->requirePresence('data', 'create')
            ->notEmptyString('data');

        $validator
            ->integer('expires')
            ->requirePresence('expires', 'create')
            ->notEmptyString('expires');

        return $validator;
    }
}

<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\SiteSession;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Behavior\TimestampBehavior;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SiteSessions Model
 *
 * @method SiteSession get($primaryKey, $options = [])
 * @method SiteSession newEntity(array $data, array $options = [])
 * @method SiteSession[] newEntities(array $data, array $options = [])
 * @method SiteSession|false save(EntityInterface $entity, $options = [])
 * @method SiteSession saveOrFail(EntityInterface $entity, $options = [])
 * @method SiteSession patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method SiteSession[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method SiteSession findOrCreate($search, ?callable $callback = null, $options = [])
 * @mixin TimestampBehavior
 * @method SiteSession[]|ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method SiteSession newEmptyEntity()
 * @method SiteSession[]|ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method SiteSession[]|ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method SiteSession[]|ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
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
     * @param Validator $validator Validator instance.
     * @return Validator
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

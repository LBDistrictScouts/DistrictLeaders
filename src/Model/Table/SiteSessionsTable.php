<?php
namespace App\Model\Table;

use App\Model\Entity\SiteSession;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SiteSessions Model
 *
 * @method SiteSession get($primaryKey, $options = [])
 * @method SiteSession newEntity($data = null, array $options = [])
 * @method SiteSession[] newEntities(array $data, array $options = [])
 * @method SiteSession|false save(EntityInterface $entity, $options = [])
 * @method SiteSession saveOrFail(EntityInterface $entity, $options = [])
 * @method SiteSession patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method SiteSession[] patchEntities($entities, array $data, array $options = [])
 * @method SiteSession findOrCreate($search, callable $callback = null, $options = [])
 *
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
    public function initialize(array $config)
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
    public function validationDefault(Validator $validator)
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

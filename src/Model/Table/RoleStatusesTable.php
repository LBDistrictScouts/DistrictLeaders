<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\RoleStatus;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Association\HasMany;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RoleStatuses Model
 *
 * @property RolesTable&HasMany $Roles
 * @method RoleStatus get($primaryKey, $options = [])
 * @method RoleStatus newEntity(array $data, array $options = [])
 * @method RoleStatus[] newEntities(array $data, array $options = [])
 * @method RoleStatus|false save(EntityInterface $entity, $options = [])
 * @method RoleStatus saveOrFail(EntityInterface $entity, $options = [])
 * @method RoleStatus patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method RoleStatus[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method RoleStatus findOrCreate($search, ?callable $callback = null, $options = [])
 * @method RoleStatus[]|ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method RoleStatus newEmptyEntity()
 * @method RoleStatus[]|ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method RoleStatus[]|ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method RoleStatus[]|ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class RoleStatusesTable extends Table
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

        $this->setTable('role_statuses');
        $this->setDisplayField('role_status');
        $this->setPrimaryKey('id');

        $this->hasMany('Roles', [
            'foreignKey' => 'role_status_id',
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
            ->scalar('role_status')
            ->maxLength('role_status', 255)
            ->requirePresence('role_status', 'create')
            ->notEmptyString('role_status')
            ->add('role_status', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
        $rules->add($rules->isUnique(['role_status']));

        return $rules;
    }
}

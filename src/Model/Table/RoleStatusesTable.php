<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RoleStatuses Model
 *
 * @property \App\Model\Table\RolesTable&\App\Model\Table\HasMany $Roles
 * @method \App\Model\Entity\RoleStatus get($primaryKey, $options = [])
 * @method \App\Model\Entity\RoleStatus newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\RoleStatus[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RoleStatus|false save(\App\Model\Table\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RoleStatus saveOrFail(\App\Model\Table\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RoleStatus patchEntity(\App\Model\Table\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RoleStatus[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\RoleStatus findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\RoleStatus[]|\App\Model\Table\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\RoleStatus newEmptyEntity()
 * @method \App\Model\Entity\RoleStatus[]|\App\Model\Table\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\RoleStatus[]|\App\Model\Table\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\RoleStatus[]|\App\Model\Table\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
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
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
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
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['role_status']));

        return $rules;
    }
}

<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CampRoleTypes Model
 *
 * @property \App\Model\Table\CampRolesTable&\App\Model\Table\HasMany $CampRoles
 * @method \App\Model\Entity\CampRoleType get($primaryKey, $options = [])
 * @method \App\Model\Entity\CampRoleType newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\CampRoleType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CampRoleType|false save(\App\Model\Table\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CampRoleType saveOrFail(\App\Model\Table\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CampRoleType patchEntity(\App\Model\Table\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CampRoleType[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CampRoleType findOrCreate($search, ?callable $callback = null, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @method \App\Model\Entity\CampRoleType[]|\App\Model\Table\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CampRoleType newEmptyEntity()
 * @method \App\Model\Entity\CampRoleType[]|\App\Model\Table\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\CampRoleType[]|\App\Model\Table\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CampRoleType[]|\App\Model\Table\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CampRoleTypesTable extends Table
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

        $this->setTable('camp_role_types');
        $this->setDisplayField('camp_role_type');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('CampRoles', [
            'foreignKey' => 'camp_role_type_id',
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
            ->scalar('camp_role_type')
            ->maxLength('camp_role_type', 30)
            ->requirePresence('camp_role_type', 'create')
            ->notEmptyString('camp_role_type')
            ->add('camp_role_type', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
        $rules->add($rules->isUnique(['camp_role_type']));

        return $rules;
    }
}

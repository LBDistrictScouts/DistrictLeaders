<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\CampRoleType;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Association\HasMany;
use Cake\ORM\Behavior\TimestampBehavior;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CampRoleTypes Model
 *
 * @property CampRolesTable&HasMany $CampRoles
 * @method CampRoleType get($primaryKey, $options = [])
 * @method CampRoleType newEntity(array $data, array $options = [])
 * @method CampRoleType[] newEntities(array $data, array $options = [])
 * @method CampRoleType|false save(EntityInterface $entity, $options = [])
 * @method CampRoleType saveOrFail(EntityInterface $entity, $options = [])
 * @method CampRoleType patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method CampRoleType[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method CampRoleType findOrCreate($search, ?callable $callback = null, $options = [])
 * @mixin TimestampBehavior
 * @method CampRoleType[]|ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method CampRoleType newEmptyEntity()
 * @method CampRoleType[]|ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method CampRoleType[]|ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method CampRoleType[]|ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
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
     * @param Validator $validator Validator instance.
     * @return Validator
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
     * @param RulesChecker $rules The rules object to be modified.
     * @return RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['camp_role_type']));

        return $rules;
    }
}

<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\CampRole;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Behavior\TimestampBehavior;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CampRoles Model
 *
 * @property CampsTable&BelongsTo $Camps
 * @property UsersTable&BelongsTo $Users
 * @property CampRoleTypesTable&BelongsTo $CampRoleTypes
 * @method CampRole get($primaryKey, $options = [])
 * @method CampRole newEntity(array $data, array $options = [])
 * @method CampRole[] newEntities(array $data, array $options = [])
 * @method CampRole|false save(EntityInterface $entity, $options = [])
 * @method CampRole saveOrFail(EntityInterface $entity, $options = [])
 * @method CampRole patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method CampRole[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method CampRole findOrCreate($search, ?callable $callback = null, $options = [])
 * @mixin TimestampBehavior
 * @method CampRole[]|ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method CampRole newEmptyEntity()
 * @method CampRole[]|ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method CampRole[]|ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method CampRole[]|ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class CampRolesTable extends Table
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

        $this->setTable('camp_roles');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Camps', [
            'foreignKey' => 'camp_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('CampRoleTypes', [
            'foreignKey' => 'camp_role_type_id',
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
        $rules->add($rules->existsIn(['camp_id'], 'Camps'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['camp_role_type_id'], 'CampRoleTypes'));

        return $rules;
    }
}

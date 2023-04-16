<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CampRoles Model
 *
 * @property \App\Model\Table\CampsTable&\App\Model\Table\BelongsTo $Camps
 * @property \App\Model\Table\UsersTable&\App\Model\Table\BelongsTo $Users
 * @property \App\Model\Table\CampRoleTypesTable&\App\Model\Table\BelongsTo $CampRoleTypes
 * @method \App\Model\Entity\CampRole get($primaryKey, $options = [])
 * @method \App\Model\Entity\CampRole newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\CampRole[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CampRole|false save(\App\Model\Table\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CampRole saveOrFail(\App\Model\Table\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CampRole patchEntity(\App\Model\Table\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CampRole[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CampRole findOrCreate($search, ?callable $callback = null, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @method \App\Model\Entity\CampRole[]|\App\Model\Table\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CampRole newEmptyEntity()
 * @method \App\Model\Entity\CampRole[]|\App\Model\Table\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\CampRole[]|\App\Model\Table\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CampRole[]|\App\Model\Table\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
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
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
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
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['camp_id'], 'Camps'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['camp_role_type_id'], 'CampRoleTypes'));

        return $rules;
    }
}

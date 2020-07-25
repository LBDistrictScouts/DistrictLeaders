<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DirectoryGroups Model
 *
 * @property \App\Model\Table\DirectoriesTable&\Cake\ORM\Association\BelongsTo $Directories
 * @property \App\Model\Table\RoleTypesTable&\Cake\ORM\Association\BelongsToMany $RoleTypes
 * @method \App\Model\Entity\DirectoryGroup get($primaryKey, $options = [])
 * @method \App\Model\Entity\DirectoryGroup newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DirectoryGroup[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DirectoryGroup|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DirectoryGroup saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DirectoryGroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DirectoryGroup[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DirectoryGroup findOrCreate($search, callable $callback = null, $options = [])
 * @property \Cake\ORM\Table&\Cake\ORM\Association\HasMany $DirectoryGroupsRoleTypes
 */
class DirectoryGroupsTable extends Table
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

        $this->setTable('directory_groups');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Directories', [
            'foreignKey' => 'directory_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsToMany('RoleTypes', [
            'foreignKey' => 'directory_group_id',
            'targetForeignKey' => 'role_type_id',
            'joinTable' => 'role_types_directory_groups',
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
            ->scalar('directory_group_name')
            ->maxLength('directory_group_name', 255)
            ->requirePresence('directory_group_name', 'create')
            ->notEmptyString('directory_group_name');

        $validator
            ->scalar('directory_group_email')
            ->maxLength('directory_group_email', 100)
            ->requirePresence('directory_group_email', 'create')
            ->notEmptyString('directory_group_email')
            ->add('directory_group_email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('directory_group_reference')
            ->maxLength('directory_group_reference', 64)
            ->allowEmptyString('directory_group_reference')
            ->add('directory_group_reference', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
        $rules->add($rules->isUnique(['directory_group_email']));
        $rules->add($rules->isUnique(['directory_group_reference']));
        $rules->add($rules->existsIn(['directory_id'], 'Directories'));

        return $rules;
    }
}

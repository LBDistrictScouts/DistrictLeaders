<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DirectoryUsers Model
 *
 * @property \App\Model\Table\DirectoriesTable&\Cake\ORM\Association\BelongsTo $Directories
 * @method \App\Model\Entity\DirectoryUser get($primaryKey, $options = [])
 * @method \App\Model\Entity\DirectoryUser newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DirectoryUser[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DirectoryUser|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DirectoryUser saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DirectoryUser patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DirectoryUser[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DirectoryUser findOrCreate($search, callable $callback = null, $options = [])
 */
class DirectoryUsersTable extends Table
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

        $this->setTable('directory_users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Directories', [
            'foreignKey' => 'directory_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsToMany('Users', [
            'through' => 'UserContacts',
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
            ->scalar('directory_user_reference')
            ->maxLength('directory_user_reference', 64)
            ->requirePresence('directory_user_reference', 'create')
            ->notEmptyString('directory_user_reference')
            ->add('directory_user_reference', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('given_name')
            ->maxLength('given_name', 64)
            ->requirePresence('given_name', 'create')
            ->notEmptyString('given_name');

        $validator
            ->scalar('family_name')
            ->maxLength('family_name', 64)
            ->requirePresence('family_name', 'create')
            ->notEmptyString('family_name');

        $validator
            ->scalar('primary_email')
            ->maxLength('primary_email', 64)
            ->requirePresence('primary_email', 'create')
            ->notEmptyString('primary_email')
            ->add('primary_email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
        $rules->add($rules->isUnique(['directory_user_reference']));
        $rules->add($rules->isUnique(['primary_email']));
        $rules->add($rules->existsIn(['directory_id'], 'Directories'));

        return $rules;
    }
}

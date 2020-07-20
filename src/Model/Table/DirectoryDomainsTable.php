<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DirectoryDomains Model
 *
 * @property \App\Model\Table\DirectoriesTable&\Cake\ORM\Association\BelongsTo $Directories
 *
 * @method \App\Model\Entity\DirectoryDomain get($primaryKey, $options = [])
 * @method \App\Model\Entity\DirectoryDomain newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DirectoryDomain[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DirectoryDomain|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DirectoryDomain saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DirectoryDomain patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DirectoryDomain[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DirectoryDomain findOrCreate($search, callable $callback = null, $options = [])
 */
class DirectoryDomainsTable extends Table
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

        $this->setTable('directory_domains');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Directories', [
            'foreignKey' => 'directory_id',
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

        $validator
            ->scalar('directory_domain')
            ->maxLength('directory_domain', 255)
            ->requirePresence('directory_domain', 'create')
            ->notEmptyString('directory_domain')
            ->add('directory_domain', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->boolean('ingest')
            ->notEmptyString('ingest');

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
        $rules->add($rules->isUnique(['directory_domain']));
        $rules->add($rules->existsIn(['directory_id'], 'Directories'));

        return $rules;
    }
}

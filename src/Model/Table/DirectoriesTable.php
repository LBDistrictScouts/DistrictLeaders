<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Directory;
use Cake\Database\Schema\TableSchemaInterface;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Directories Model
 *
 * @property \App\Model\Table\DirectoryTypesTable&\Cake\ORM\Association\BelongsTo $DirectoryTypes
 * @property \App\Model\Table\DirectoryDomainsTable&\Cake\ORM\Association\HasMany $DirectoryDomains
 * @property \App\Model\Table\DirectoryGroupsTable&\Cake\ORM\Association\HasMany $DirectoryGroups
 * @property \App\Model\Table\DirectoryUsersTable&\Cake\ORM\Association\HasMany $DirectoryUsers
 * @method \App\Model\Entity\Directory get($primaryKey, $options = [])
 * @method \App\Model\Entity\Directory newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Directory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Directory|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Directory saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Directory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Directory[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Directory findOrCreate($search, callable $callback = null, $options = [])
 */
class DirectoriesTable extends Table
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

        $this->setTable('directories');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('DirectoryTypes', [
            'foreignKey' => 'directory_type_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('DirectoryDomains', [
            'foreignKey' => 'directory_id',
        ]);
        $this->hasMany('DirectoryGroups', [
            'foreignKey' => 'directory_id',
        ]);
        $this->hasMany('DirectoryUsers', [
            'foreignKey' => 'directory_id',
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
            ->scalar('directory')
            ->maxLength('directory', 64)
            ->requirePresence('directory', 'create')
            ->notEmptyString('directory')
            ->add('directory', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->allowEmptyString('configuration_payload');

        $validator
            ->boolean('active')
            ->notEmptyString('active');

        $validator
            ->scalar('customer_reference')
            ->maxLength('customer_reference', 12)
            ->allowEmptyString('customer_reference')
            ->add('customer_reference', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->allowEmptyString('authorisation_token');

        return $validator;
    }

    /**
     * @param \Cake\Database\Schema\TableSchemaInterface $schema The Schema to be modified
     * @return \Cake\Database\Schema\TableSchemaInterface
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _initializeSchema(TableSchemaInterface $schema): TableSchemaInterface
    {
        $schema->setColumnType(Directory::FIELD_CONFIGURATION_PAYLOAD, 'json');
        $schema->setColumnType(Directory::FIELD_AUTHORISATION_TOKEN, 'json');

        return $schema;
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
        $rules->add($rules->isUnique(['directory']));
        $rules->add($rules->isUnique(['customer_reference']));
        $rules->add($rules->existsIn(['directory_type_id'], 'DirectoryTypes'));

        return $rules;
    }

    /**
     * @param \App\Model\Entity\Directory $directory The directory to be Populated
     * @return array
     */
    public function populate(Directory $directory)
    {
        $directoryCount = $this->DirectoryDomains->populate($directory);

        return compact('directoryCount');
    }
}

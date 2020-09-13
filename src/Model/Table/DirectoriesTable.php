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
        $this->setDisplayField(Directory::FIELD_DIRECTORY);
        $this->setPrimaryKey(Directory::FIELD_ID);

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
            ->integer(Directory::FIELD_ID)
            ->allowEmptyString(Directory::FIELD_ID, null, 'create');

        $validator
            ->scalar(Directory::FIELD_DIRECTORY)
            ->maxLength(Directory::FIELD_DIRECTORY, 64)
            ->requirePresence(Directory::FIELD_DIRECTORY, 'create')
            ->notEmptyString(Directory::FIELD_DIRECTORY)
            ->add(Directory::FIELD_DIRECTORY, 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->boolean(Directory::FIELD_ACTIVE)
            ->notEmptyString(Directory::FIELD_ACTIVE);

        $validator
            ->scalar(Directory::FIELD_CUSTOMER_REFERENCE)
            ->maxLength(Directory::FIELD_CUSTOMER_REFERENCE, 12)
            ->allowEmptyString(Directory::FIELD_CUSTOMER_REFERENCE)
            ->add(Directory::FIELD_CUSTOMER_REFERENCE, 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->allowEmptyString(Directory::FIELD_AUTHORISATION_TOKEN);

        return $validator;
    }

    /**
     * @param \Cake\Database\Schema\TableSchemaInterface $schema The Schema to be modified
     * @return \Cake\Database\Schema\TableSchemaInterface
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _initializeSchema(TableSchemaInterface $schema): TableSchemaInterface
    {
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
        $rules->add($rules->isUnique([Directory::FIELD_DIRECTORY]));
        $rules->add($rules->isUnique([Directory::FIELD_CUSTOMER_REFERENCE]));
        $rules->add($rules->existsIn([Directory::FIELD_DIRECTORY_TYPE_ID], 'DirectoryTypes'));

        return $rules;
    }

    /**
     * @param \App\Model\Entity\Directory $directory The directory to be Populated
     * @return array
     */
    public function populate(Directory $directory)
    {
        $domainsCount = $this->DirectoryDomains->populate($directory);
        $usersCount = $this->DirectoryUsers->populate($directory);
        $groupsCount = $this->DirectoryGroups->populate($directory);

        return compact('domainsCount', 'usersCount', 'groupsCount');
    }

    /**
     * @param \App\Model\Entity\Directory $directory The Parent Directory
     * @param \Google_Service_Directory_User $directoryUser The Google API Response for User
     * @return \App\Model\Entity\Directory|false
     */
    public function setCustomerReference(Directory $directory, \Google_Service_Directory_User $directoryUser): Directory
    {
        $directory->set(Directory::FIELD_CUSTOMER_REFERENCE, $directoryUser->getCustomerId());

        return $this->save($directory);
    }
}

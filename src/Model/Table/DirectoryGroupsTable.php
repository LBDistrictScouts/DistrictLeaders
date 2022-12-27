<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Directory;
use App\Model\Entity\DirectoryDomain;
use App\Model\Entity\DirectoryGroup;
use App\Utility\GoogleBuilder;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\BelongsToMany;
use Cake\ORM\Association\HasMany;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Google_Exception;
use Google_Service_Directory_Group;

/**
 * DirectoryGroups Model
 *
 * @property DirectoriesTable&BelongsTo $Directories
 * @property RoleTypesTable&BelongsToMany $RoleTypes
 * @method DirectoryGroup get($primaryKey, $options = [])
 * @method DirectoryGroup newEntity(array $data, array $options = [])
 * @method DirectoryGroup[] newEntities(array $data, array $options = [])
 * @method DirectoryGroup|false save(EntityInterface $entity, $options = [])
 * @method DirectoryGroup saveOrFail(EntityInterface $entity, $options = [])
 * @method DirectoryGroup patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method DirectoryGroup[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method DirectoryGroup findOrCreate($search, ?callable $callback = null, $options = [])
 * @property Table&HasMany $DirectoryGroupsRoleTypes
 * @method DirectoryGroup newEmptyEntity()
 * @method DirectoryGroup[]|ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method DirectoryGroup[]|ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method DirectoryGroup[]|ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method DirectoryGroup[]|ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
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
     * @param Validator $validator Validator instance.
     * @return Validator
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
     * @param RulesChecker $rules The rules object to be modified.
     * @return RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['directory_group_email']));
        $rules->add($rules->isUnique(['directory_group_reference']));
        $rules->add($rules->existsIn(['directory_id'], 'Directories'));

        return $rules;
    }

    /**
     * @param Directory $directory The directory to be Populated with Groups
     * @param DirectoryDomain|null $directoryDomain Limit to a Domain
     * @return int
     */
    public function populate(Directory $directory, ?DirectoryDomain $directoryDomain = null): int
    {
        $domain = null;
        if ($directoryDomain instanceof DirectoryDomain) {
            $domain = $directoryDomain->directory_domain;
        }

        $groupCount = 0;
        $continue = true;
        $pageToken = null;

        while ($continue) {
            try {
                $result = $this->populateFromList($directory, $domain, $groupCount, $pageToken);
            } catch (Google_Exception $e) {
                return $groupCount;
            }
            $groupCount += $result['count'];
            $pageToken = $result['pageToken'];

            if (is_null($pageToken) || empty($pageToken)) {
                $continue = false;
            }
        }

        return $groupCount;
    }

    /**
     * @param Directory $directory The Directory
     * @param string|null $directoryDomain The Directory Domain
     * @param int $count The Count start point
     * @param null $pageToken The Next Page Token
     * @return array
     * @throws Google_Exception
     */
    public function populateFromList(
        Directory $directory,
        ?string $directoryDomain = null,
        $count = 0,
        $pageToken = null
    ): array {
        $userList = GoogleBuilder::getGroupList($directory, $directoryDomain, 20, $pageToken);
        $pageToken = $userList->getNextPageToken();

        /** @var Google_Service_Directory_Group $group */
        foreach ($userList->getGroups() as $group) {
            $result = $this->findOrMake($group, $directory->id);
            if ($result) {
                $count += 1;
            }
        }

        return compact('count', 'pageToken');
    }

    /**
     * @param Google_Service_Directory_Group $directoryGroup Google Response Object
     * @param int $directoryId ID of the Parent Directory
     * @return DirectoryDomain|array|EntityInterface|false|null
     */
    public function findOrMake(Google_Service_Directory_Group $directoryGroup, int $directoryId)
    {
        $search = [
            DirectoryGroup::FIELD_DIRECTORY_GROUP_REFERENCE => $directoryGroup->getId(),
            DirectoryGroup::FIELD_DIRECTORY_ID => $directoryId,
        ];

        return $this->findOrCreate($search, function (DirectoryGroup $entity) use ($directoryGroup) {
            $entity->set($entity::FIELD_DIRECTORY_GROUP_NAME, $directoryGroup->getName());
            $entity->set($entity::FIELD_DIRECTORY_GROUP_EMAIL, $directoryGroup->getEmail());
        });
    }
}

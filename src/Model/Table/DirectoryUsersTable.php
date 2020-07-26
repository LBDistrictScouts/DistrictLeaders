<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Directory;
use App\Model\Entity\DirectoryDomain;
use App\Model\Entity\DirectoryUser;
use App\Utility\GoogleBuilder;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Google_Service_Directory_User;

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
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsToMany $Users
 * @property \App\Model\Table\UserContactsTable&\Cake\ORM\Association\HasMany $UserContacts
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

    /**
     * @param \App\Model\Entity\Directory $directory The directory to be Populated with Domains
     * @param \App\Model\Entity\DirectoryDomain|null $directoryDomain Limit to Domain
     * @return int
     * @throws \Google_Exception
     */
    public function populate(Directory $directory, ?DirectoryDomain $directoryDomain = null): int
    {
        $domain = null;
        if ($directoryDomain instanceof DirectoryDomain) {
            $domain = $directoryDomain->directory_domain;
        }

        $count = 0;
        $continue = true;
        $pageToken = null;

        while ($continue) {
            $result = $this->populateFromList($directory, $domain, $count, $pageToken);
            $count += $result['count'];
            $pageToken = $result['pageToken'];

            if (is_null($pageToken) || empty($pageToken)) {
                $continue = false;
            }
        }

        return $count;
    }

    /**
     * @param \App\Model\Entity\Directory $directory The Directory
     * @param string|null $directoryDomain The Directory Domain
     * @param int $count The Count start point
     * @param null $pageToken The Next Page Token
     * @return array
     * @throws \Google_Exception
     */
    public function populateFromList(
        Directory $directory,
        ?string $directoryDomain = null,
        $count = 0,
        $pageToken = null
    ): array {
        $userList = GoogleBuilder::getUserList($directory, $directoryDomain, 20, $pageToken);
        $pageToken = $userList->getNextPageToken();

        /** @var \Google_Service_Directory_user $user */
        foreach ($userList->getUsers() as $user) {
            $result = $this->findOrMake($user, $directory->id);
            if ($result) {
                $count += 1;
            }
        }

        return compact('count', 'pageToken');
    }

    /**
     * @param \Google_Service_Directory_User $directoryUser Google Response Object
     * @param int $directoryId ID of the Parent Directory
     * @return \App\Model\Entity\DirectoryDomain|array|\Cake\Datasource\EntityInterface|false|null
     */
    public function findOrMake(Google_Service_Directory_User $directoryUser, int $directoryId)
    {
        $search = [
            DirectoryUser::FIELD_DIRECTORY_USER_REFERENCE => $directoryUser->getId(),
            DirectoryUser::FIELD_DIRECTORY_ID => $directoryId,
        ];

        return $this->findOrCreate($search, function (DirectoryUser $entity) use ($directoryUser) {
            $entity->set($entity::FIELD_GIVEN_NAME, $directoryUser->getName()->getGivenName());
            $entity->set($entity::FIELD_FAMILY_NAME, $directoryUser->getName()->getFamilyName());
            $entity->set($entity::FIELD_PRIMARY_EMAIL, $directoryUser->getPrimaryEmail());
        });
    }
}

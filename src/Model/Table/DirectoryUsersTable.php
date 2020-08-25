<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Directory;
use App\Model\Entity\DirectoryDomain;
use App\Model\Entity\DirectoryUser;
use App\Model\Entity\User;
use App\Model\Entity\UserContact;
use App\Model\Entity\UserContactType;
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
 * @mixin \App\Model\Behavior\CaseableBehavior
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
        $this->setDisplayField(DirectoryUser::FIELD_FULL_NAME);
        $this->setPrimaryKey(DirectoryUser::FIELD_ID);

        $this->addBehavior('Caseable', [
            'case_columns' => [
                DirectoryUser::FIELD_PRIMARY_EMAIL => 'l',
                DirectoryUser::FIELD_GIVEN_NAME => 'p',
                DirectoryUser::FIELD_FAMILY_NAME => 'p',
            ],
        ]);

        $this->belongsTo('Directories', [
            'foreignKey' => 'directory_id',
            'joinType' => 'INNER',
        ]);

        $this->hasMany('UserContacts', [
            'foreignKey' => 'directory_user_id',
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
            ->integer(DirectoryUser::FIELD_ID)
            ->allowEmptyString(DirectoryUser::FIELD_ID, null, 'create');

        $validator
            ->scalar(DirectoryUser::FIELD_DIRECTORY_USER_REFERENCE)
            ->maxLength(DirectoryUser::FIELD_DIRECTORY_USER_REFERENCE, 64)
            ->requirePresence(DirectoryUser::FIELD_DIRECTORY_USER_REFERENCE, 'create')
            ->notEmptyString(DirectoryUser::FIELD_DIRECTORY_USER_REFERENCE)
            ->add(
                DirectoryUser::FIELD_DIRECTORY_USER_REFERENCE,
                'unique',
                ['rule' => 'validateUnique', 'provider' => 'table']
            );

        $validator
            ->scalar(DirectoryUser::FIELD_GIVEN_NAME)
            ->maxLength(DirectoryUser::FIELD_GIVEN_NAME, 64)
            ->requirePresence(DirectoryUser::FIELD_GIVEN_NAME, 'create')
            ->notEmptyString(DirectoryUser::FIELD_GIVEN_NAME);

        $validator
            ->scalar(DirectoryUser::FIELD_FAMILY_NAME)
            ->maxLength(DirectoryUser::FIELD_FAMILY_NAME, 64)
            ->requirePresence(DirectoryUser::FIELD_FAMILY_NAME, 'create')
            ->notEmptyString(DirectoryUser::FIELD_FAMILY_NAME);

        $validator
            ->scalar(DirectoryUser::FIELD_PRIMARY_EMAIL)
            ->maxLength(DirectoryUser::FIELD_PRIMARY_EMAIL, 64)
            ->requirePresence(DirectoryUser::FIELD_PRIMARY_EMAIL, 'create')
            ->notEmptyString(DirectoryUser::FIELD_PRIMARY_EMAIL)
            ->add(DirectoryUser::FIELD_PRIMARY_EMAIL, 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
        $rules->add($rules->isUnique([DirectoryUser::FIELD_DIRECTORY_USER_REFERENCE]));
        $rules->add($rules->isUnique([DirectoryUser::FIELD_PRIMARY_EMAIL]));
        $rules->add($rules->existsIn([DirectoryUser::FIELD_DIRECTORY_ID], 'Directories'));

        return $rules;
    }

    /**
     * @param \App\Model\Entity\Directory $directory The directory to be Populated with Domains
     * @param \App\Model\Entity\DirectoryDomain|null $directoryDomain Limit to Domain
     * @return int
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
            try {
                $result = $this->populateFromList($directory, $domain, $count, $pageToken);
            } catch (\Google_Exception $e) {
                return $count;
            }
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
            $result = $this->findOrMake($user, $directory);
            if ($result) {
                $count += 1;
            }
        }

        return compact('count', 'pageToken');
    }

    /**
     * @param \Google_Service_Directory_User $directoryUser Google Response Object
     * @param \App\Model\Entity\Directory $directory The Parent Directory
     * @return \App\Model\Entity\DirectoryDomain|array|\Cake\Datasource\EntityInterface|false|null
     */
    public function findOrMake(Google_Service_Directory_User $directoryUser, Directory $directory)
    {
        $search = [
            DirectoryUser::FIELD_DIRECTORY_USER_REFERENCE => $directoryUser->getId(),
            DirectoryUser::FIELD_DIRECTORY_ID => $directory->id,
        ];

        if (empty($directory->customer_reference) || $directory->customer_reference == 'my_customer') {
            $this->Directories->setCustomerReference($directory, $directoryUser);
        }

        return $this->findOrCreate($search, function (DirectoryUser $entity) use ($directoryUser) {
            $entity->set($entity::FIELD_GIVEN_NAME, $directoryUser->getName()->getGivenName());
            $entity->set($entity::FIELD_FAMILY_NAME, $directoryUser->getName()->getFamilyName());
            $entity->set($entity::FIELD_PRIMARY_EMAIL, $directoryUser->getPrimaryEmail());
        });
    }

    /**
     * @param \App\Model\Entity\DirectoryUser $directoryUser User to be estimated
     * @return \App\Model\Entity\User|null
     */
    public function detectUser(DirectoryUser $directoryUser): ?User
    {
        $existing = $this->UserContacts->find()->where([
            UserContact::FIELD_DIRECTORY_USER_ID => $directoryUser->id,
        ]);

        if ($existing->count() == 1) {
            $foundExisting = $this->get($directoryUser->id, ['contain' => 'Users'])->users;
            foreach ($foundExisting as $user) {
                return $user;
            }
        }

        $nameMatches = $this->Users->find()
            ->select([DirectoryUser::FIELD_ID])
            ->distinct([DirectoryUser::FIELD_ID])
            ->where([
                User::FIELD_FIRST_NAME => $directoryUser->given_name,
                User::FIELD_LAST_NAME => $directoryUser->family_name,
            ]);

        $primaryEmailMatches = $this->Users->find()
            ->select([DirectoryUser::FIELD_ID])
            ->distinct([DirectoryUser::FIELD_ID])
            ->where([User::FIELD_EMAIL => $directoryUser->primary_email]);

        $matches = $nameMatches->union($primaryEmailMatches);

        if ($matches->count() == 1) {
            $result = $matches->first();
            $result = $this->Users->get($result->id);
            if (isset($result) && $result instanceof User) {
                return $result;
            }
        }

//        $otherEmailMatches = $this->UserContacts->find()->where([])


        if ($matches->count() > 1) {
            $matchingNames = $nameMatches
                ->select([User::FIELD_ID])
                ->distinct();

            $intersection = $primaryEmailMatches
                ->where([User::FIELD_ID . ' IS IN' => $matchingNames]);

            if ($intersection->count() == 1) {
                $result = $intersection->first();
                if (isset($result) && $result instanceof User) {
                    return $result;
                }
            }
        }

        return null;
    }

    /**
     * @param \App\Model\Entity\DirectoryUser $directoryUser Source Directory User
     * @param \App\Model\Entity\User $user User to be Linked via UserContact
     * @return bool
     */
    public function linkUser(DirectoryUser $directoryUser, User $user): bool
    {
        $contacts = $this->UserContacts->find()->where([
            UserContact::FIELD_CONTACT_FIELD => $directoryUser->primary_email,
            UserContact::FIELD_USER_ID => $user->id,
        ]);

        if ($contacts->count() == 1) {
            $contact = $contacts->first();
        } else {
            $contact = $this->UserContacts->newEmptyEntity();
            $emailTypeId = $this->UserContacts->UserContactTypes->find()
                ->where([
                    UserContactType::FIELD_USER_CONTACT_TYPE => 'Email',
                ])
                ->first()
                ->id;
            $contact->set(UserContact::FIELD_USER_CONTACT_TYPE_ID, $emailTypeId);
            $contact->set(UserContact::FIELD_USER_ID, $user->id);
            $contact->set(UserContact::FIELD_CONTACT_FIELD, $directoryUser->primary_email);
        }

        $contact->set(UserContact::FIELD_DIRECTORY_USER_ID, $directoryUser->id);

        return (bool)$this->UserContacts->save($contact);
    }

//    public function convertUser(DirectoryUser $directoryUser)
//    {
//
//    }
}

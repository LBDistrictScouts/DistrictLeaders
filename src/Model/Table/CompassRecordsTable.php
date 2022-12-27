<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Behavior\CaseableBehavior;
use App\Model\Behavior\CsvBehavior;
use App\Model\Entity\CompassRecord;
use App\Model\Entity\DirectoryUser;
use App\Model\Entity\DocumentVersion;
use App\Model\Entity\RoleType;
use App\Model\Entity\ScoutGroup;
use App\Model\Entity\User;
use App\Model\Entity\UserContact;
use App\Model\Table\Exceptions\BadUserDataException;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\ModelAwareTrait;
use Cake\Datasource\ResultSetInterface;
use Cake\Event\Event;
use Cake\Log\Log;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Search\Model\Behavior\SearchBehavior;

/**
 * CompassRecords Model
 *
 * @property DocumentVersionsTable&BelongsTo $DocumentVersions
 * @method CompassRecord get($primaryKey, $options = [])
 * @method CompassRecord newEntity(array $data, array $options = [])
 * @method CompassRecord[] newEntities(array $data, array $options = [])
 * @method CompassRecord|false save(EntityInterface $entity, $options = [])
 * @method CompassRecord saveOrFail(EntityInterface $entity, $options = [])
 * @method CompassRecord patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method CompassRecord[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method CompassRecord findOrCreate($search, ?callable $callback = null, $options = [])
 * @mixin CaseableBehavior
 * @mixin CsvBehavior
 * @mixin SearchBehavior
 * @property UsersTable $Users
 * @property ScoutGroupsTable $ScoutGroups
 * @property RoleTypesTable $RoleTypes
 * @property DirectoryUsersTable $DirectoryUsers
 * @method CompassRecord newEmptyEntity()
 * @method CompassRecord[]|ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method CompassRecord[]|ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method CompassRecord[]|ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method CompassRecord[]|ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @mixin SearchBehavior
 * @mixin CaseableBehavior
 * @mixin CsvBehavior
 */
class CompassRecordsTable extends Table
{
    use ModelAwareTrait;

    /**
     * @var UsersTable
     */
    private $Users;

    /**
     * @var DirectoryUsersTable
     */
    private $DirectoryUsers;

    /**
     * @var ScoutGroupsTable
     */
    private $ScoutGroups;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('compass_records');
        $this->setDisplayField('title');
        $this->setPrimaryKey(CompassRecord::FIELD_ID);

        $this->addBehavior('Search.Search');

        $this->addBehavior('Caseable', [
            'case_columns' => [
                CompassRecord::FIELD_EMAIL => 'l',
                CompassRecord::FIELD_POSTCODE => 'u',
                CompassRecord::FIELD_FORENAMES => 'p',
                CompassRecord::FIELD_SURNAME => 'p',
                CompassRecord::FIELD_ADDRESS_LINE1 => 't',
                CompassRecord::FIELD_ADDRESS_LINE2 => 't',
                CompassRecord::FIELD_ADDRESS_LINE3 => 't',
                CompassRecord::FIELD_ADDRESS_TOWN => 't',
                CompassRecord::FIELD_ADDRESS_COUNTRY => 't',
                CompassRecord::FIELD_ADDRESS_COUNTY => 't',
            ],
        ]);

        $this->addBehavior('Csv', [
            'length' => 0,
            'delimiter' => ',',
            'enclosure' => '"',
            'escape' => '\\',
            // Generates a Model.field headings row from the csv file
            'headers' => true,
            // If true, String $content is the data, not a path to the file
            'text' => false,
        ]);

        $this->belongsTo('DocumentVersions', [
            'foreignKey' => 'document_version_id',
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
            ->integer(CompassRecord::FIELD_ID)
            ->allowEmptyString(CompassRecord::FIELD_ID, null, 'create');

        $validator
            ->integer(CompassRecord::FIELD_DOCUMENT_VERSION_ID)
            ->requirePresence(CompassRecord::FIELD_DOCUMENT_VERSION_ID, 'create')
            ->notEmptyString(CompassRecord::FIELD_DOCUMENT_VERSION_ID);

        $validator
            ->integer(CompassRecord::FIELD_MEMBERSHIP_NUMBER)
            ->requirePresence(CompassRecord::FIELD_MEMBERSHIP_NUMBER, 'create')
            ->notEmptyString(CompassRecord::FIELD_MEMBERSHIP_NUMBER);

        $validator
            ->scalar(CompassRecord::FIELD_TITLE)
            ->maxLength(CompassRecord::FIELD_TITLE, 255)
            ->allowEmptyString(CompassRecord::FIELD_TITLE);

        $validator
            ->scalar(CompassRecord::FIELD_FORENAMES)
            ->maxLength(CompassRecord::FIELD_FORENAMES, 255)
            ->allowEmptyString(CompassRecord::FIELD_FORENAMES);

        $validator
            ->scalar(CompassRecord::FIELD_SURNAME)
            ->maxLength(CompassRecord::FIELD_SURNAME, 255)
            ->allowEmptyString(CompassRecord::FIELD_SURNAME);

        $validator
            ->scalar(CompassRecord::FIELD_ADDRESS)
            ->maxLength(CompassRecord::FIELD_ADDRESS, 255)
            ->allowEmptyString(CompassRecord::FIELD_ADDRESS);

        $validator
            ->scalar(CompassRecord::FIELD_ADDRESS_LINE1)
            ->maxLength(CompassRecord::FIELD_ADDRESS_LINE1, 255)
            ->allowEmptyString(CompassRecord::FIELD_ADDRESS_LINE1);

        $validator
            ->scalar(CompassRecord::FIELD_ADDRESS_LINE2)
            ->maxLength(CompassRecord::FIELD_ADDRESS_LINE2, 255)
            ->allowEmptyString(CompassRecord::FIELD_ADDRESS_LINE2);

        $validator
            ->scalar(CompassRecord::FIELD_ADDRESS_LINE3)
            ->maxLength(CompassRecord::FIELD_ADDRESS_LINE3, 255)
            ->allowEmptyString(CompassRecord::FIELD_ADDRESS_LINE3);

        $validator
            ->scalar(CompassRecord::FIELD_ADDRESS_TOWN)
            ->maxLength(CompassRecord::FIELD_ADDRESS_TOWN, 255)
            ->allowEmptyString(CompassRecord::FIELD_ADDRESS_TOWN);

        $validator
            ->scalar(CompassRecord::FIELD_ADDRESS_COUNTY)
            ->maxLength(CompassRecord::FIELD_ADDRESS_COUNTY, 255)
            ->allowEmptyString(CompassRecord::FIELD_ADDRESS_COUNTY);

        $validator
            ->scalar(CompassRecord::FIELD_POSTCODE)
            ->maxLength(CompassRecord::FIELD_POSTCODE, 255)
            ->allowEmptyString(CompassRecord::FIELD_POSTCODE);

        $validator
            ->scalar(CompassRecord::FIELD_ADDRESS_COUNTRY)
            ->maxLength(CompassRecord::FIELD_ADDRESS_COUNTRY, 255)
            ->allowEmptyString(CompassRecord::FIELD_ADDRESS_COUNTRY);

        $validator
            ->scalar(CompassRecord::FIELD_ROLE)
            ->maxLength(CompassRecord::FIELD_ROLE, 255)
            ->allowEmptyString(CompassRecord::FIELD_ROLE);

        $validator
            ->scalar(CompassRecord::FIELD_LOCATION)
            ->maxLength(CompassRecord::FIELD_LOCATION, 255)
            ->allowEmptyString(CompassRecord::FIELD_LOCATION);

        $validator
            ->scalar(CompassRecord::FIELD_PHONE)
            ->maxLength(CompassRecord::FIELD_PHONE, 255)
            ->allowEmptyString(CompassRecord::FIELD_PHONE);

        $validator
            ->email(CompassRecord::FIELD_EMAIL)
            ->allowEmptyString(CompassRecord::FIELD_EMAIL);

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
        $rules->add($rules->isUnique([
            CompassRecord::FIELD_MEMBERSHIP_NUMBER,
            CompassRecord::FIELD_DOCUMENT_VERSION_ID,
            CompassRecord::FIELD_ROLE,
        ]));
        $rules->add($rules->existsIn([CompassRecord::FIELD_DOCUMENT_VERSION_ID], 'DocumentVersions'));

        return $rules;
    }

    /**
     * Stores emails as lower case.
     *
     * @param Event $event The event being processed.
     * @return bool
     */
    public function beforeRules(Event $event)
    {
        $entity = $event->getData('entity');

        if (empty($entity->address_county)) {
            $entity->address_county = 'Hertfordshire';
        }

        return true;
    }

    /**
     * @param CompassRecord $compassRecord The Compass Record
     * @return string
     */
    public function shouldMerge(CompassRecord $compassRecord): string
    {
        $this->loadModel('Users');
        $this->loadModel('ScoutGroups');
        $this->loadModel('RoleTypes');

        $compassRecord = $this->prepareRecord($compassRecord);

        if ($this->detectUser($compassRecord) instanceof User) {
            return 'Merge';
        }

        if (!$this->ScoutGroups->domainVerify($compassRecord->email)) {
            return 'Invalid Email Address.';
        }

        $groupExists = [
            ScoutGroup::FIELD_SCOUT_GROUP => $compassRecord->clean_group,
        ];
        $groupAliasExists = [
            ScoutGroup::FIELD_GROUP_ALIAS => $compassRecord->clean_group,
        ];
        if (!($this->ScoutGroups->exists($groupExists) || $this->ScoutGroups->exists($groupAliasExists))) {
            return 'Invalid Scout Group.';
        }

        if ($compassRecord->provisional) {
            return 'Provisional Role.';
        }

        $roleExist = [
            RoleType::FIELD_ROLE_TYPE => $compassRecord->clean_role,
            RoleType::FIELD_IMPORT_TYPE => true,
        ];
        if ($this->RoleTypes->exists($roleExist)) {
            return 'Merge';
        }

        return 'No Role Type.';
    }

    /**
     * @param CompassRecord $compassRecord The Compass Record
     * @return bool
     */
    public function doAutoMerge(CompassRecord $compassRecord): bool
    {
        if ($this->shouldMerge($compassRecord) == 'Merge') {
            return true;
        }

        return false;
    }

    /**
     * @param DocumentVersion $documentVersion Document Version ID
     * @return array
     */
    public function autoMerge(DocumentVersion $documentVersion): array
    {
        $query = $this->find();
        if (!is_null($documentVersion)) {
            $query->where([
                CompassRecord::FIELD_DOCUMENT_VERSION_ID => $documentVersion->id,
            ]);
        }
        $successfullyMerged = 0;
        $newConsumedRecords = 0;
        $unmergedRecords = 0;
        $skippedRecords = 0;
        $totalParsedRecords = $query->count();

        foreach ($query as $record) {
            if ($record instanceof CompassRecord && $this->doAutoMerge($record)) {
                $record = $this->prepareRecord($record);

                $user = $this->detectUser($record);
                if (!$user instanceof User) {
                    $user = null;
                }
                if ($this->importUser($record, $user)) {
                    $successfullyMerged++;
                    if (is_null($user)) {
                        $newConsumedRecords++;
                    }
                } else {
                    $unmergedRecords++;
                }
            } else {
                $skippedRecords++;
            }
        }

        return compact(
            'successfullyMerged',
            'totalParsedRecords',
            'newConsumedRecords',
            'unmergedRecords',
            'skippedRecords'
        );
    }

    /**
     * @param array $data The Data to be converted into Records
     * @param DocumentVersion $version The Document Version for Associating
     * @return int
     */
    public function parseImportedData(array $data, DocumentVersion $version): int
    {
        $entities = $this->newEntities($data);

        $fail = 0;
        $total = count($entities);

        foreach ($entities as $entity) {
            $entity->set(CompassRecord::FIELD_DOCUMENT_VERSION_ID, $version->id);

            // Save entity
            if (!$this->save($entity)) {
                $errorString = 'Record not created. ';
                $errorString = $entity->get('forenames') . ' ' . $entity->get('surname') . ' ';
                foreach ($entity->getErrors() as $field => $error) {
                    $errorString .= $field . ' ';
                    $errorString .= $entity->get($field) . ' ';
                    foreach ($error as $errorType => $message) {
                        $errorString .= $errorType . ' ';
                        $errorString .= $message;
                    }
                }
                Log::info($errorString, $entity->toArray());

                $fail++;
            }
        }

        return $total - $fail;
    }

    /**
     * Matches the record with alternative sources of up to date emails
     *
     * @param CompassRecord $record The Compass Record to be Reconciled
     * @return CompassRecord
     */
    public function prepareRecord(CompassRecord $record): CompassRecord
    {
        $this->loadModel('DirectoryUsers');
        $this->loadModel('ScoutGroups');

        // If existing record is a valid domain email, make no changes
        if ($this->ScoutGroups->domainVerify($record->email)) {
            return $record;
        }

        $userNameMatch = $this->DirectoryUsers->find()->where([
            DirectoryUser::FIELD_GIVEN_NAME => $record->get(CompassRecord::FIELD_FIRST_NAME),
            DirectoryUser::FIELD_FAMILY_NAME => $record->get(CompassRecord::FIELD_LAST_NAME),
        ]);

        if ($userNameMatch->count() >= 1) {
            $directoryUser = $userNameMatch->first();
            $record->set(CompassRecord::FIELD_EMAIL, $directoryUser->get(DirectoryUser::FIELD_PRIMARY_EMAIL));
            $record = $this->save($record);
        }

        return $record;
    }

    /**
     * @param CompassRecord $record The Record for Detection
     * @return User|null
     */
    public function detectUser(CompassRecord $record): ?User
    {
        $this->loadModel('Users');

        $existing = $this->Users->find()->where([
            User::FIELD_MEMBERSHIP_NUMBER => $record->membership_number,
        ]);

        if ($existing->count() == 1) {
            return $this->Users->get($existing->first()->get(User::FIELD_ID));
        }

        $existing = $this->Users->find()->where([
            User::FIELD_EMAIL => $record->email,
        ]);

        if ($existing->count() == 1) {
            return $this->Users->get($existing->first()->get(User::FIELD_ID));
        }

        $nameMatches = $this->Users->find()
            ->select([User::FIELD_ID])
            ->distinct([User::FIELD_ID])
            ->where([
                User::FIELD_FIRST_NAME => $record->first_name,
                User::FIELD_LAST_NAME => $record->last_name,
            ]);

        $primaryEmailMatches = $this->Users->find()
            ->select([User::FIELD_ID])
            ->distinct([User::FIELD_ID])
            ->where([User::FIELD_EMAIL => $record->email]);

        if ($nameMatches->count() >= 1 && $primaryEmailMatches->count() >= 1) {
            $nameList = [];
            foreach ($nameMatches as $nameMatch) {
                array_push($nameList, $nameMatch->get(User::FIELD_ID));
            }

            if (empty($nameList) || count($nameList) == 0) {
                return null;
            }

            $intersection = $primaryEmailMatches
                ->whereInList(User::FIELD_ID, $nameList);

            if ($intersection->count() === 1) {
                $result = $intersection->first();
                $result = $this->Users->get($result->id);
                if (isset($result) && $result instanceof User) {
                    return $result;
                }
            }
        }

        return null;
    }

    private $userMap = [
        User::FIELD_MEMBERSHIP_NUMBER => CompassRecord::FIELD_MEMBERSHIP_NUMBER,
        User::FIELD_FIRST_NAME => CompassRecord::FIELD_FIRST_NAME,
        User::FIELD_LAST_NAME => CompassRecord::FIELD_LAST_NAME,
        User::FIELD_EMAIL => CompassRecord::FIELD_EMAIL,
        User::FIELD_ADDRESS_LINE_1 => CompassRecord::FIELD_ADDRESS_LINE1,
        User::FIELD_ADDRESS_LINE_2 => CompassRecord::FIELD_ADDRESS_LINE2,
        User::FIELD_CITY => CompassRecord::FIELD_ADDRESS_TOWN,
        User::FIELD_COUNTY => CompassRecord::FIELD_ADDRESS_COUNTY,
        User::FIELD_POSTCODE => CompassRecord::FIELD_POSTCODE,
    ];

    /**
     * @param CompassRecord $record Record to be Consumed
     * @param User|null $user User to be linked if detected
     * @return bool
     */
    public function importUser(CompassRecord $record, ?User $user = null): bool
    {
        $this->loadModel('Users');
        $new = false;

        if (is_null($user)) {
            $user = $this->detectUser($record);
        }
        $record = $this->prepareRecord($record);

        if (is_null($user)) {
            $user = $this->Users->newEmptyEntity();
            $new = true;
        }
        if (!$user instanceof User) {
            return false;
        }

        foreach ($this->userMap as $userField => $recordField) {
            if (!$user->hasValue($userField)) {
                $user->set($userField, $record->get($recordField));
            }
        }

        if ($new) {
            $user = $this->Users->save($user, ['validate' => 'new']);
        } else {
            $user = $this->Users->save($user);
        }

        if (!$user instanceof User) {
            throw new BadUserDataException();
        }

        return $this->mergeUser($record, $user);
    }

    /**
     * @param CompassRecord $record The Compass Record for Merging
     * @param User $user User to be Linked via UserContact
     * @return bool
     */
    public function mergeUser(CompassRecord $record, User $user): bool
    {
        $this->loadModel('Users');

        $this->Users->UserContacts->makePhone($user, $record->phone);

        try {
            $emailContact = $this->Users->UserContacts->makeEmail($user, $record->email);
        } catch (BadUserDataException $exception) {
            return false;
        }

        if (!$emailContact instanceof UserContact) {
            return false;
        }

        if (
            !$this->Users->Roles->mergeRole(
                $user,
                $record->clean_section,
                $record->clean_group,
                $record->clean_role,
                $record->clean_section_type,
                null,
                $emailContact
            )
        ) {
            return false;
        }

        $this->delete($record);

        return true;
    }
}

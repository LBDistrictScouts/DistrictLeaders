<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\CompassRecord;
use App\Model\Entity\DocumentVersion;
use App\Model\Entity\User;
use App\Model\Entity\UserContact;
use Cake\Datasource\ModelAwareTrait;
use Cake\Event\Event;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CompassRecords Model
 *
 * @property \App\Model\Table\DocumentVersionsTable&\Cake\ORM\Association\BelongsTo $DocumentVersions
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\CompassRecord get($primaryKey, $options = [])
 * @method \App\Model\Entity\CompassRecord newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CompassRecord[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CompassRecord|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CompassRecord saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CompassRecord patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CompassRecord[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CompassRecord findOrCreate($search, callable $callback = null, $options = [])
 * @mixin \App\Model\Behavior\CaseableBehavior
 * @mixin \App\Model\Behavior\CsvBehavior
 */
class CompassRecordsTable extends Table
{
    use ModelAwareTrait;

    /**
     * @var \App\Model\Table\UsersTable
     */
    private $Users;

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
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
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
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique([
            CompassRecord::FIELD_MEMBERSHIP_NUMBER,
            CompassRecord::FIELD_DOCUMENT_VERSION_ID,
        ]));
        $rules->add($rules->existsIn([CompassRecord::FIELD_DOCUMENT_VERSION_ID], 'DocumentVersions'));

        return $rules;
    }

    /**
     * Stores emails as lower case.
     *
     * @param \Cake\Event\Event $event The event being processed.
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
     * @param \App\Model\Entity\CompassRecord $mergeContact The Contact Data to be merged - Must contain all keys.
     * @return bool|\Cake\Datasource\EntityInterface
     */
    public function integrateContact(CompassRecord $mergeContact)
    {
        if (
            !$mergeContact->hasValue(CompassRecord::FIELD_MEMBERSHIP_NUMBER)
            || !$mergeContact->hasValue(CompassRecord::FIELD_FORENAMES)
            || !$mergeContact->hasValue(CompassRecord::FIELD_EMAIL)
//            || !key_exists('clean_role', $mergeContact)
//            || !key_exists('clean_group', $mergeContact)
//            || !key_exists('clean_section', $mergeContact)
        ) {
            return false;
        }

        $contacts = TableRegistry::get('Contacts');

        $contact = $contacts->findOrMakeContact($mergeContact);

        if (!($contact instanceof Entity)) {
            return false;
        }

        $roleTypes = TableRegistry::get('RoleTypes');
        $sections = TableRegistry::get('Sections');

        $sectionCreate = [
            'group' => $mergeContact['clean_group'],
            'section' => $mergeContact['clean_section'],
        ];
        $section = $sections->findOrMakeSection($sectionCreate);

        if ($section instanceof Entity) {
            $sectionId = $section->id;

            $roleTypeArr = [
                'role' => $mergeContact['clean_role'],
                'section_type_id' => $section->section_type_id,
            ];

            $roleType = $roleTypes->findOrMakeRoleType($roleTypeArr);

            if ($roleType instanceof Entity) {
                $roleTypeId = $roleType->id;
            }
        }

        if (isset($sectionId) && isset($roleTypeId)) {
            $roles = TableRegistry::get('Roles');

            $roleArray = [
                'section_id' => $sectionId,
                'role_type_id' => $roleTypeId,
                'contact_id' => $contact->id,
                'provisional' => $mergeContact['provisional'],
            ];

            $role = $roles->newEntity($roleArray);

            $roles->save($role);
        }

        return $contact;
    }

    /**
     * @param \App\Model\Entity\CompassRecord $compassRecord The Compass Record
     * @return bool
     */
    public function autoMerge(CompassRecord $compassRecord)
    {
        $this->loadModel('Users');

        $membershipCount = $this->Users
            ->find()
            ->where(['membership_number' => $compassRecord->membership_number])
            ->count();

        if ($membershipCount == 1) {
            return true;
        }

        $allowedRoles = [
            'Group Treasurer',
            'District Commissioner',
            'Section Leader',
            'Scout Active Support Member',
            'Assistant Section Leader',
            'District Explorer Scout Commissioner',
            'County Scout Active Support Member',
            'Group Executive Committee Member',
            'District Badge Secretary',
            'Group Chairman',
        ];

        if (in_array($compassRecord->clean_role, $allowedRoles) && !$compassRecord->provisional) {
            return true;
        }

        return false;
    }

    /**
     * @param array $data The Data to be converted into Records
     * @param \App\Model\Entity\DocumentVersion $version The Document Version for Associating
     * @return array
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
                $fail++;
            }
        }

        return $total - $fail;
    }

    /**
     * @param \App\Model\Entity\CompassRecord $record The Record for Detection
     * @return \App\Model\Entity\User|null
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
     * @param \App\Model\Entity\CompassRecord $record Record to be Consumed
     * @return bool
     */
    public function importUser(CompassRecord $record): bool
    {
        $this->loadModel('Users');

        /** @var \App\Model\Entity\User $user */
        $user = $this->Users->newEmptyEntity();
        $user = $this->mapUser($record, $user, true);

        return $this->mergeUser($record, $user);
    }

    /**
     * @param \App\Model\Entity\CompassRecord $record Record to Consumed
     * @param \App\Model\Entity\User $user User to be Updated
     * @return bool
     */
    public function linkUser(CompassRecord $record, User $user): bool
    {
        $user = $this->mapUser($record, $user);

        if (!$user instanceof User) {
            return false;
        }

        return $this->mergeUser($record, $user);
    }

    /**
     * @param \App\Model\Entity\CompassRecord $record Record to Consumed
     * @param \App\Model\Entity\User $user User to be Updated
     * @param bool $new Is the User New
     * @return \App\Model\Entity\User
     */
    public function mapUser(CompassRecord $record, User $user, bool $new = false): User
    {
        $this->loadModel('Users');

        foreach ($this->userMap as $userField => $recordField) {
            if (!$user->hasValue($userField)) {
                $user->set($userField, $record->get($recordField));
            }
        }

        if ($new) {
            return $this->Users->save($user, ['validate' => 'new']);
        }

        return $this->Users->save($user);
    }

    /**
     * @param \App\Model\Entity\CompassRecord $record The Compass Record for Merging
     * @param \App\Model\Entity\User $user User to be Linked via UserContact
     * @return bool
     */
    public function mergeUser(CompassRecord $record, User $user): bool
    {
        $this->loadModel('Users');

        $this->Users->UserContacts->makePhone($user, $record->phone);

        $emailContact = $this->Users->UserContacts->makeEmail($user, $record->email);
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

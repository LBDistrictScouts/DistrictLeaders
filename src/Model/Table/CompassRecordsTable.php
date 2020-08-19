<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\CompassRecord;
use Cake\Datasource\ModelAwareTrait;
use Cake\Event\Event;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CompassRecords Model
 *
 * @property \App\Model\Table\DocumentVersionsTable&\Cake\ORM\Association\BelongsTo $DocumentVersions
 * @method \App\Model\Entity\CompassRecord get($primaryKey, $options = [])
 * @method \App\Model\Entity\CompassRecord newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CompassRecord[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CompassRecord|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CompassRecord saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CompassRecord patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CompassRecord[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CompassRecord findOrCreate($search, callable $callback = null, $options = [])
 * @mixin \App\Model\Behavior\CaseableBehavior
 * @property \App\Model\Table\UsersTable $Users
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
}

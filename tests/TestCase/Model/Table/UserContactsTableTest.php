<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\UserContact;
use App\Model\Table\UserContactsTable;
use Cake\I18n\FrozenTime;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UserContactsTable Test Case
 */
class UserContactsTableTest extends TestCase
{
    use ModelTestTrait;

    /**
     * Test subject
     *
     * @var \App\Model\Table\UserContactsTable
     */
    protected $UserContacts;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.UserStates',
        'app.Users',
        'app.CapabilitiesRoleTypes',
        'app.Capabilities',
        'app.ScoutGroups',
        'app.SectionTypes',
        'app.RoleTemplates',
        'app.RoleTypes',
        'app.RoleStatuses',
        'app.Sections',
        'app.Audits',
        'app.UserContactTypes',
        'app.UserContacts',
        'app.Roles',

        'app.DirectoryTypes',
        'app.Directories',
        'app.DirectoryDomains',
        'app.DirectoryUsers',
        'app.DirectoryGroups',
        'app.RoleTypesDirectoryGroups',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('UserContacts') ? [] : ['className' => UserContactsTable::class];
        $this->UserContacts = $this->getTableLocator()->get('UserContacts', $config);

        $now = new FrozenTime('2018-12-26 23:22:30');
        FrozenTime::setTestNow($now);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->UserContacts);

        parent::tearDown();
    }

    /**
     * Get Good Set Function
     *
     * @return array
     * @throws
     */
    private function getGood()
    {
        $good = [
            'user_id' => 1,
            'user_contact_type_id' => 1,
            'contact_field' => random_int(111, 999) . 'jacob.llama' . random_int(111, 999) . '@4thgoat.org.uk',
        ];

        return $good;
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize(): void
    {
        $dates = [
            UserContact::FIELD_MODIFIED,
            UserContact::FIELD_CREATED,
            UserContact::FIELD_DELETED,
        ];

        $expected = [
            UserContact::FIELD_ID => 1,
            UserContact::FIELD_CONTACT_FIELD => 'james@peach.com',
            UserContact::FIELD_USER_ID => 1,
            UserContact::FIELD_USER_CONTACT_TYPE_ID => 1,
            UserContact::FIELD_VERIFIED => true,
            UserContact::FIELD_DIRECTORY_USER_ID => 1,
            UserContact::FIELD_VALIDATED => true,
        ];

        $this->validateInitialise($expected, $this->UserContacts, 2, $dates);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $good = $this->getGood();

        $new = $this->UserContacts->newEntity($good);
        TestCase::assertInstanceOf('App\Model\Entity\UserContact', $this->UserContacts->save($new));

        $required = [
            UserContact::FIELD_CONTACT_FIELD,
        ];
        $this->validateRequired($required, $this->UserContacts, [$this, 'getGood']);

        $notEmpties = [
            UserContact::FIELD_CONTACT_FIELD,
            UserContact::FIELD_USER_ID,
            UserContact::FIELD_USER_CONTACT_TYPE_ID,
        ];
        $this->validateNotEmpties($notEmpties, $this->UserContacts, [$this, 'getGood']);

        $maxLengths = [
            UserContact::FIELD_CONTACT_FIELD => 64,
        ];
        $this->validateMaxLengths($maxLengths, $this->UserContacts, [$this, 'getGood']);
    }

    /**
     * Test validationEmail method
     *
     * @return void
     */
    public function testValidationEmail(): void
    {
        $good = $this->getGood();

        $new = $this->UserContacts->newEntity($good, ['validate' => 'email']);
        TestCase::assertInstanceOf('App\Model\Entity\UserContact', $this->UserContacts->save($new));

        $required = [
            UserContact::FIELD_CONTACT_FIELD,
            UserContact::FIELD_USER_ID,
            UserContact::FIELD_USER_CONTACT_TYPE_ID,
        ];
        $this->validateRequired($required, $this->UserContacts, [$this, 'getGood'], 'email');

        $notEmpties = [
            UserContact::FIELD_CONTACT_FIELD,
            UserContact::FIELD_USER_ID,
            UserContact::FIELD_USER_CONTACT_TYPE_ID,
        ];
        $this->validateNotEmpties($notEmpties, $this->UserContacts, [$this, 'getGood'], 'email');

        // Bad Email
        $this->validateEmail(UserContact::FIELD_CONTACT_FIELD, $this->UserContacts, [$this, 'getGood'], 'email');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->validateUniqueRule(
            [UserContact::FIELD_USER_ID, UserContact::FIELD_CONTACT_FIELD],
            $this->UserContacts,
            [$this, 'getGood']
        );

        // User Contact Type Exists
        $this->validateExistsRule(UserContact::FIELD_USER_CONTACT_TYPE_ID, $this->UserContacts, $this->UserContacts->UserContactTypes, [$this, 'getGood']);

        // User Exists
        $this->validateExistsRule(UserContact::FIELD_USER_ID, $this->UserContacts, $this->UserContacts->Users, [$this, 'getGood']);

        // Directory User Exists
        $this->validateExistsRule(UserContact::FIELD_DIRECTORY_USER_ID, $this->UserContacts, $this->UserContacts->DirectoryUsers, [$this, 'getGood']);
    }

    /**
     * Test isValidDomainEmail method
     *
     * @return void
     */
    public function testIsValidDomainEmail(): void
    {
        TestCase::assertFalse($this->UserContacts->isValidDomainEmail('cheese@buttons.com', []));
        TestCase::assertTrue($this->UserContacts->isValidDomainEmail('jacob@4thgoat.org.uk', []));
    }
}

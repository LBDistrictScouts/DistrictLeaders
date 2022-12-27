<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Entity;

use App\Model\Entity\User;
use App\Model\Entity\UserContact;
use App\Model\Table\UserContactsTable;
use App\Test\TestCase\Controller\AppTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Entity\User Test Case
 *
 * @property UserContactsTable $UserContacts
 */
class UserContactTest extends TestCase
{
    use AppTestTrait;

    /**
     * Test subject
     *
     * @var User
     */
    public $UserContact;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.UserStates',
        'app.Users',
        'app.CapabilitiesRoleTypes',
        'app.Capabilities',
        'app.ScoutGroups',
        'app.SectionTypes',
        'app.Sections',

        'app.RoleTemplates',
        'app.RoleTypes',
        'app.RoleStatuses',

        'app.Audits',
        'app.UserContactTypes',
        'app.UserContacts',

        'app.DirectoryTypes',
        'app.Directories',
        'app.DirectoryDomains',
        'app.DirectoryUsers',
        'app.DirectoryGroups',
        'app.RoleTypesDirectoryGroups',

        'app.Roles',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->UserContact = new UserContact();
        $this->UserContacts = $this->getTableLocator()->get('UserContacts');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->UserContact);
        unset($this->UserContacts);

        parent::tearDown();
    }

    public function provideVerified()
    {
        return [
            'Email not in Directory' => [
                [
                    UserContact::FIELD_USER_ID => 1,
                    UserContact::FIELD_USER_CONTACT_TYPE_ID => 1,
                    UserContact::FIELD_CONTACT_FIELD => 'jacob@llama.com',
                ],
                false,
            ],
            'Already True' => [
                [
                    UserContact::FIELD_USER_ID => 1,
                    UserContact::FIELD_USER_CONTACT_TYPE_ID => 1,
                    UserContact::FIELD_CONTACT_FIELD => 'jacob@llama.com',
                    UserContact::FIELD_VERIFIED => true,
                ],
                true,
            ],
            'Email in DirectoryUsers' => [
                [
                    UserContact::FIELD_USER_ID => 1,
                    UserContact::FIELD_USER_CONTACT_TYPE_ID => 1,
                    UserContact::FIELD_CONTACT_FIELD => 'fish@4thgoat.org.uk',
                ],
                true,
            ],
        ];
    }

    /**
     * Test getOriginalData method
     *
     * @dataProvider provideVerified
     * @param array $data The Data Array for Setting
     * @param bool $expected The Expected Outcome
     * @return void
     */
    public function testSetVerified(array $data, bool $expected)
    {
        $this->UserContact = $this->UserContacts->newEntity($data);
        $result = $this->UserContacts->save($this->UserContact);
        TestCase::assertInstanceOf(UserContact::class, $result);

        $this->UserContact = $this->UserContacts->get($result->get(UserContact::FIELD_ID));
        TestCase::assertEquals($expected, $this->UserContact->verified);
    }
}

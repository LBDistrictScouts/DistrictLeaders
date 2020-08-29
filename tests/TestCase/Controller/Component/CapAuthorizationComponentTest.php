<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\CapAuthorizationComponent;
use App\Model\Entity\User;
use App\Model\Table\UsersTable;
use App\Test\TestCase\Controller\AppTestTrait;
use Authorization\AuthorizationService;
use Authorization\IdentityDecorator;
use Authorization\Policy\OrmResolver;
use Authorization\Policy\ResultInterface;
use Cake\Controller\ComponentRegistry;
use Cake\Controller\Controller;
use Cake\Http\ServerRequest;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\CapAuthorizationComponent Test Case
 */
class CapAuthorizationComponentTest extends TestCase
{
    use AppTestTrait;

    /**
     * @var \App\Controller\Component\CapAuthorizationComponent The Component under test
     */
    public $Authorization;

    /**
     * @var \Cake\Controller\Controller The Controller for Request
     */
    public $Controller;

    /**
     * @var \Cake\Controller\ComponentRegistry The Registry of Components
     */
    public $ComponentRegistry;

    /**
     * Test subject
     *
     * @var \App\Model\Table\UsersTable The Table for Users
     */
    public $Users;

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
        'app.RoleTemplates',
        'app.RoleTypes',
        'app.RoleStatuses',
        'app.Sections',
        'app.Audits',
        'app.UserContactTypes',
        'app.UserContacts',
        'app.Roles',
        'app.CampTypes',
        'app.Camps',
        'app.CampRoleTypes',
        'app.CampRoles',
        'app.NotificationTypes',
        'app.Notifications',
        'app.EmailSends',
        'app.Tokens',
        'app.EmailResponseTypes',
        'app.EmailResponses',

        'app.DirectoryTypes',
        'app.Directories',
        'app.DirectoryDomains',
        'app.DirectoryUsers',
        'app.DirectoryGroups',
        'app.RoleTypesDirectoryGroups',

        'app.FileTypes',
        'app.DocumentTypes',
        'app.Documents',
        'app.DocumentVersions',
        'app.DocumentEditions',
    ];

    /**
     * setUp method
     *
     * @param bool $admin
     * @return void
     */
    public function setUp(bool $admin = true): void
    {
        parent::setUp();

        $config = $this->getTableLocator()->exists('Users') ? [] : ['className' => UsersTable::class];
        $this->Users = $this->getTableLocator()->get('Users', $config);

        $user = $this->Users->patchCapabilities($this->Users->get(1));
        if (!$admin) {
            $capabilities = $user->capabilities;
            $key = array_search('ALL', $capabilities['user']);
            unset($capabilities['user'][$key]);
            $user->set($user::FIELD_CAPABILITIES, $capabilities);
        }

        $service = new AuthorizationService(new OrmResolver());
        $identity = new IdentityDecorator($service, $user);

        $request = new ServerRequest([
            'params' => ['controller' => 'Articles', 'action' => 'edit'],
        ]);
        $request = $request
            ->withAttribute('authorization', $service)
            ->withAttribute('identity', $identity);

        $this->Controller = new Controller($request);
        $this->ComponentRegistry = new ComponentRegistry($this->Controller);
        $this->Authorization = new CapAuthorizationComponent($this->ComponentRegistry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Authorization);

        parent::tearDown();
    }

    public function provideSee()
    {
        return [
            'Non Admin User' => [
                false,
                [
                    User::FIELD_USERNAME,
                    User::FIELD_MEMBERSHIP_NUMBER,
                    User::FIELD_FIRST_NAME,
                    User::FIELD_LAST_NAME,
                    User::FIELD_EMAIL,
                    User::FIELD_ADDRESS_LINE_1,
                    User::FIELD_ADDRESS_LINE_2,
                    User::FIELD_CITY,
                    User::FIELD_COUNTY,
                    User::FIELD_POSTCODE,
                    User::FIELD_CREATED,
                    User::FIELD_MODIFIED,
                    User::FIELD_LAST_LOGIN,
                    User::FIELD_DELETED,
                    User::FIELD_LAST_LOGIN_IP,
                    User::FIELD_USER_STATE_ID,
                    User::FIELD_COGNITO_ENABLED,
                    User::FIELD_ALL_ROLE_COUNT,
                    User::FIELD_ACTIVE_ROLE_COUNT,
                    User::FIELD_ALL_EMAIL_COUNT,
                    User::FIELD_ALL_PHONE_COUNT,
                    User::FIELD_RECEIVE_EMAILS,
                    User::FIELD_VALIDATED_EMAIL_COUNT,
                    User::FIELD_VALIDATED_PHONE_COUNT,
                    User::FIELD_PASSWORD,
                    User::FIELD_USER_STATE,
                    User::FIELD_CHANGES,
                    User::FIELD_AUDITS,
                    User::FIELD_CAMP_ROLES,
                    User::FIELD_EMAIL_SENDS,
                    User::FIELD_NOTIFICATIONS,
                    User::FIELD_ROLES,
                    User::FIELD_USER_CONTACTS,
                    User::FIELD_CONTACT_EMAILS,
                    User::FIELD_CONTACT_NUMBERS,
                    User::FIELD_DIRECTORY_USERS,
                ],
            ],
            'Admin User' => [
                true,
                [],
            ],
        ];
    }

    /**
     * Test see method
     *
     * @dataProvider provideSee
     * @param bool $admin ALL/Administrative user setup
     * @param array $expectedData Expected SEE field array
     * @return void
     */
    public function testSee(bool $admin, array $expectedData)
    {
        $user = $this->Users->get(2);
        $this->setUp($admin);
        $result = $this->Authorization->see($user);
        TestCase::assertEquals($expectedData, $result);
    }

    /**
     * @return array
     */
    public function providerCheckCapability()
    {
        return [
            'Valid Special' => [
                'ALL',
                true,
                null,
                null,
                'Admin Capability Found.',
            ],
            'Valid Standard' => [
                'EDIT_GROUP',
                true,
                null,
                null,
                'Capability Found in User.',
            ],
            'Valid Standard Group' => [
                'EDIT_SECT',
                true,
                1,
                null,
                'Capability Found in Group.',
            ],
            'Invalid Standard Group' => [
                'EDIT_SECT',
                false,
                2,
                null,
                'No Valid Capability Found.',
            ],
            'Valid Standard Section' => [
                'EDIT_USER',
                true,
                null,
                1,
                'Capability Found in Section.',
            ],
            'Invalid Standard Section' => [
                'EDIT_USER',
                false,
                null,
                2,
                'No Valid Capability Found.',
            ],
            'Invalid Type' => [
                'GOAT',
                false,
                null,
                null,
                'No Valid Capability Found.',
            ],
            'Is Empty' => [
                '',
                false,
                null,
                null,
                'No Valid Capability Found.',
            ],
        ];
    }

    /**
     * Test checkCapability method
     *
     * @dataProvider providerCheckCapability
     * @param string $capability Capabilty to be Checked
     * @param bool $expected Expected Boolean Outcome
     * @return void
     */
    public function testCheckCapability(string $capability, bool $expected, ?int $group = null, ?int $section = null)
    {
        $admin = (bool)($capability == 'ALL');
        $this->setUp($admin);

        $result = $this->Authorization->checkCapability($capability, $group, $section);

        if ($result instanceof ResultInterface) {
            $result = $result->getStatus();
        }

        TestCase::assertEquals($expected, $result);
    }

    /**
     * Test checkCapability method
     *
     * @dataProvider providerCheckCapability
     * @param string $capability Capability to be Checked
     * @param bool $expected Expected Boolean Outcome
     * @param int|null $group The Group ID
     * @param int|null $section The Section ID
     * @param string $expectedReason The Reason Expected
     * @return void
     */
    public function testCheckCapabilityResult(
        string $capability,
        bool $expected,
        ?int $group,
        ?int $section,
        string $expectedReason
    ): void {
        $admin = (bool)($capability == 'ALL');
        $this->setUp($admin);

        $result = $this->Authorization->checkCapabilityResult($capability, $group, $section);

        TestCase::assertInstanceOf(ResultInterface::class, $result);
        TestCase::assertSame($expectedReason, $result->getReason());
        $result = $result->getStatus();
        TestCase::assertEquals($expected, $result);
    }

    /**
     * @return array
     */
    public function providerBuildCapability()
    {
        return [
            'All Standard' => [
                [
                    'VIEW',
                    'Sections',
                ],
                true, // Admin
                true, // Expected
                'Admin Capability Found.',
            ],
            'Invalid Standard Section' => [
                [
                    'EDIT',
                    'Users',
                    null,
                    2,
                ],
                false, // Admin
                false, // Expected
                'No Valid Capability Found.',
            ],
            'Invalid Type' => [
                [
                    'GOAT',
                    'Users',
                ],
                false, // Admin
                false, // Expected
                'Action Supplied is Invalid.',
            ],
            'Is Empty' => [
                [
                    null,
                    null,
                ],
                false, // Admin
                false, // Expected
                'Action Supplied is Invalid.',
            ],
        ];
    }

    /**
     * Test buildAndCheckCapability method
     *
     * @dataProvider providerBuildCapability
     * @param array $capArray Array for Build
     * @param bool $admin ALL cap present
     * @param bool $expected Expected Boolean Outcome
     * @param string $expectedReason The Reason Expected
     * @return void
     */
    public function testBuildAndCheckCapability(
        array $capArray,
        bool $admin,
        bool $expected,
        string $expectedReason
    ): void {
        $this->setUp($admin);
        $result = $this->Authorization->buildAndCheckCapabilityResult(...$capArray);

        TestCase::assertInstanceOf(ResultInterface::class, $result);
        TestCase::assertSame($expectedReason, $result->getReason());
        $result = $result->getStatus();
        TestCase::assertEquals($expected, $result);
    }

    /**
     * Test buildAndCheckCapability method
     *
     * @dataProvider providerBuildCapability
     * @param array $capArray Array for Build
     * @param bool $admin ALL cap present
     * @param bool $expected Expected Boolean Outcome
     * @param string $expectedReason The Reason Expected
     * @return void
     */
    public function testBuildAndCheckCapabilityResult(
        array $capArray,
        bool $admin,
        bool $expected,
        string $expectedReason
    ): void {
        $this->setUp($admin);
        $result = $this->Authorization->buildAndCheckCapabilityResult(...$capArray);

        TestCase::assertInstanceOf(ResultInterface::class, $result);
        TestCase::assertSame($expectedReason, $result->getReason());
        $result = $result->getStatus();
        TestCase::assertEquals($expected, $result);
    }
}

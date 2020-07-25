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
        'app.Notifications',
        'app.NotificationTypes',
        'app.EmailSends',
        'app.Tokens',
        'app.EmailResponseTypes',
        'app.EmailResponses',
        'app.FileTypes',
        'app.DocumentTypes',
        'app.Documents',
        'app.DocumentVersions',
        'app.DocumentEditions',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $service = new AuthorizationService(new OrmResolver());
        $identity = new IdentityDecorator($service, ['id' => 1, 'role' => 'user']);

        $request = new ServerRequest([
            'params' => ['controller' => 'Articles', 'action' => 'edit'],
        ]);
        $request = $request
            ->withAttribute('authorization', $service)
            ->withAttribute('identity', $identity);

        $this->Controller = new Controller($request);
        $this->ComponentRegistry = new ComponentRegistry($this->Controller);
        $this->Authorization = new CapAuthorizationComponent($this->ComponentRegistry);

        $config = $this->getTableLocator()->exists('Users') ? [] : ['className' => UsersTable::class];
        $this->Users = $this->getTableLocator()->get('Users', $config);
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

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test see method
     *
     * @return void
     */
    public function testSee()
    {
        // Unauthorised User
        $user = $this->Users->get(1);
        $result = $this->Authorization->see($user);
        TestCase::assertEquals([], $result);

        // Processed User
        $user = $this->Users->patchCapabilities($user);
        $this->setUp();
        $result = $this->Authorization->see($user);
        TestCase::assertEquals([
            User::FIELD_ID,
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
            User::FIELD_CAPABILITIES,
            User::FIELD_USER_STATE_ID,
            User::FIELD_COGNITO_ENABLED,
        ], $result);
    }

    /**
     * Test checkCapability method
     *
     * @return void
     */
    public function testCheckCapability()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildAndCheckCapability method
     *
     * @return void
     */
    public function testBuildAndCheckCapability()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

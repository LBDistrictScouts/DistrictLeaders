<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\CapAuthorizationComponent;
use App\Model\Table\UsersTable;
use Authorization\AuthorizationService;
use Authorization\Controller\Component\AuthorizationComponent;
use Authorization\IdentityDecorator;
use Authorization\Policy\OrmResolver;
use Cake\Controller\ComponentRegistry;
use Cake\Controller\Controller;
use Cake\Http\ServerRequest;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\CapAuthorizationComponent Test Case
 */
class CapAuthorizationComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\CapAuthorizationComponent
     */
    public $CapAuthorization;

    /**
     * Test subject
     *
     * @var \App\Model\Table\UsersTable
     */
    public $Users;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PasswordStates',
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
    public function setUp()
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
        $this->CapAuthorization = new CapAuthorizationComponent($this->ComponentRegistry);

        $config = TableRegistry::getTableLocator()->exists('Users') ? [] : ['className' => UsersTable::class];
        $this->Users = TableRegistry::getTableLocator()->get('Users', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CapAuthorization);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testSee()
    {
        // Unauthorised User
        $user = $this->Users->get(1);
        $result = $this->CapAuthorization->see($user);
        TestCase::assertEquals([], $result);

        // Processed User
        $user = $this->Users->patchCapabilities($user);
        debug($user);
        $result = $this->CapAuthorization->see($user);
        TestCase::assertEquals([], $result);
    }
}

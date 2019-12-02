<?php
namespace App\Test\TestCase\Controller;

use App\Controller\AdminController;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\AdminController Test Case
 *
 * @uses \App\Controller\AdminController
 */
class AdminControllerTest extends TestCase
{
    use AppTestTrait;

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
    ];

    /**
     * @var string $controller The Name of the controller being interrogated.
     */
    private $controller = 'Admin';

    /**
     * Test index method
     *
     * @return void
     */
    public function testStatus()
    {
        TestCase::markTestIncomplete();
        $this->tryGet(['controller' => $this->controller, 'action' => 'status']);
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testGoogle()
    {
        TestCase::markTestIncomplete();
        $this->tryGet(['controller' => $this->controller, 'action' => 'google']);
    }
}

<?php
namespace App\Test\TestCase\Controller;

use App\Controller\UsersController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\UsersController Test Case
 */
class UsersControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Users',
        'app.RoleTypes',
        'app.RoleStatuses',
        'app.Sections',
        'app.SectionTypes',
        'app.ScoutGroups',
        'app.Audits',
        'app.Roles',
        'app.CampRoleTypes',
        'app.CampRoles',
        'app.Camps',
        'app.CampTypes',
    ];

    /**
     * Test index method
     *
     * @return void
     *
     * @throws
     */
    public function testIndex()
    {
        $this->session([
            'Auth.User.id' => 1,
        ]);

        $this->get(['controller' => 'Users', 'action' => 'index']);

        $this->assertResponseOk();
    }

    /**
     * Test view method
     *
     * @return void
     *
     * @throws
     */
    public function testView()
    {
        $this->session([
            'Auth.User.id' => 1,
        ]);

        $this->get(['controller' => 'Users', 'action' => 'view', 1]);

        $this->assertResponseOk();
    }

    /**
     * Test add method
     *
     * @return void
     *
     * @throws
     */
    public function testAdd()
    {
        $this->session([
            'Auth.User.id' => 1,
        ]);

        $this->get(['controller' => 'Users', 'action' => 'add']);

        $this->assertResponseOk();

        $this->session([
            'Auth.User.id' => 1,
        ]);

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->enableRetainFlashMessages();

        $this->post([
            'controller' => 'Users',
            'action' => 'add'
        ], [
            'membership_number' => '12345',
            'first_name' => 'BOB',
            'last_name' => 'ROBERT',
            'email' => 'bob@robert.com',
            'address_line_1' => 'My House',
            'address_line_2' => '',
            'city' => 'Somewhere',
            'county' => 'Fun',
            'postcode' => 'SG8 1BN',
        ]);

        $this->assertRedirect(['controller' => 'Users', 'action' => 'view', 3]);
        $this->assertFlashElement('Flash/success');
        $this->assertFlashMessage('The user has been saved.');
    }

    /**
     * Test edit method
     *
     * @return void
     *
     * @throws
     */
    public function testEdit()
    {
        $this->session([
            'Auth.User.id' => 1,
        ]);

        $this->get(['controller' => 'Users', 'action' => 'edit', 1]);

        $this->assertResponseOk();

        $this->session([
            'Auth.User.id' => 1,
        ]);

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->enableRetainFlashMessages();

        $this->configRequest([
            'environment' => ['HTTPS' => 'on']
        ]);

        $this->post([
            'controller' => 'Users',
            'action' => 'edit',
            1
        ], [
            'membership_number' => 145921,
            'first_name' => 'Goat',
            'last_name' => 'Fish',
            'email' => 'goat@octopus.com',
            'address_line_1' => '47 Goat Ave',
            'address_line_2' => '',
            'city' => 'London',
            'county' => 'Greater London',
            'postcode' => 'PS99 4NG',
        ]);

        $this->assertRedirect(['controller' => 'Users', 'action' => 'view', 1]);
        $this->assertFlashElement('Flash/success');
        $this->assertFlashMessage('The user has been saved.');
    }

    /**
     * Test delete method
     *
     * @return void
     *
     * @throws
     */
    public function testDelete()
    {
        $this->session([
            'Auth.User.id' => 2,
        ]);

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->enableRetainFlashMessages();

        $this->delete([
            'controller' => 'Users',
            'action' => 'delete',
            1
        ]);

        $this->assertRedirect(['controller' => 'Users', 'action' => 'index']);
        $this->assertFlashElement('Flash/success');
        $this->assertFlashMessage('The user has been deleted.');
    }
}

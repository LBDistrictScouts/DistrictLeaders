<?php
namespace App\Test\TestCase\Controller;

use App\Controller\UsersController;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\UsersController Test Case
 */
class UsersControllerTest extends TestCase
{
    use AppTestTrait;
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
        $this->login();

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
        $this->login();

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
        $this->login();

        $this->get(['controller' => 'Users', 'action' => 'add']);

        $this->assertResponseOk();

        $this->login();

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
        $this->login();

        $this->get(['controller' => 'Users', 'action' => 'edit', 1]);

        $this->assertResponseOk();

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
        $this->login();

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

    /**
     * Test login method
     *
     * @return void
     * @throws \PHPUnit\Exception
     */
    public function testLogin()
    {
        $this->get([
            'controller' => 'Users',
            'action' => 'login',
        ]);

        $this->assertResponseOk();
    }

    /**
     * Test reset method
     *
     * @return void
     */
    public function testReset()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test username method
     *
     * @return void
     */
    public function testUsername()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test token method
     *
     * @return void
     */
    public function testToken()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

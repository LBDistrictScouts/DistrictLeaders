<?php
namespace App\Test\TestCase\Controller;

use App\Controller\ScoutGroupsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\ScoutGroupsController Test Case
 */
class ScoutGroupsControllerTest extends TestCase
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

        $this->get(['controller' => 'ScoutGroups', 'action' => 'index']);

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

        $this->get(['controller' => 'ScoutGroups', 'action' => 'view', 1]);

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

        $this->get(['controller' => 'ScoutGroups', 'action' => 'add']);

        $this->assertResponseOk();

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->enableRetainFlashMessages();

        $this->post([
            'controller' => 'ScoutGroups',
            'action' => 'add'
        ], [
            'scout_group' => '4th Goatville',
            'group_alias' => '4th Goat',
            'number_stripped' => 4,
            'charity_number' => 12345,
            'group_domain' => 'https://4thgoat.com',
        ]);

        $this->assertRedirect(['controller' => 'ScoutGroups', 'action' => 'view', 2]);
        $this->assertFlashElement('Flash/success');
        $this->assertFlashMessage('The scout group has been saved.');
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

        $this->get(['controller' => 'ScoutGroups', 'action' => 'edit', 1]);

        $this->assertResponseOk();

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->enableRetainFlashMessages();

        $this->configRequest([
            'environment' => ['HTTPS' => 'on']
        ]);

        $this->post([
            'controller' => 'ScoutGroups',
            'action' => 'edit',
            1
        ], [
            'scout_group' => '4th Goatville',
            'group_alias' => '4th Goat',
            'number_stripped' => 4,
            'charity_number' => 12345,
            'group_domain' => 'https://4thgoat.com',
        ]);

        $this->assertRedirect(['controller' => 'ScoutGroups', 'action' => 'view', 1]);
        $this->assertFlashElement('Flash/success');
        $this->assertFlashMessage('The scout group has been saved.');
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

        /** Setup the thing to be deleted. */
        $this->post([
            'controller' => 'ScoutGroups',
            'action' => 'add'
        ], [
            'scout_group' => '9th Goatville',
            'group_alias' => '9th Goat',
            'number_stripped' => 9,
            'charity_number' => 897,
            'group_domain' => 'https://9th.com',
        ]);

        $this->delete([
            'controller' => 'ScoutGroups',
            'action' => 'delete',
            2
        ]);

        $this->assertRedirect(['controller' => 'ScoutGroups', 'action' => 'index']);
        $this->assertFlashElement('Flash/success');
        $this->assertFlashMessage('The scout group has been deleted.');
    }
}

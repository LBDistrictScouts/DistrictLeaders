<?php
namespace App\Test\TestCase\Controller;

use App\Controller\RoleTypesController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\RoleTypesController Test Case
 */
class RoleTypesControllerTest extends TestCase
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
        'app.Capabilities',
        'app.CapabilitiesRoleTypes',
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

        $this->get(['controller' => 'RoleTypes', 'action' => 'index']);

        $this->assertResponseOk();
    }

    /**
     * Test view method
     *
     * @return void
     * @throws \PHPUnit\Exception
     */
    public function testView()
    {
        $this->login();

        $this->get(['controller' => 'RoleTypes', 'action' => 'view', 1]);

        $this->assertResponseOk();
    }

    /**
     * Test add method
     *
     * @return void
     * @throws \PHPUnit\Exception
     */
    public function testAdd()
    {
        $this->login();

        $this->get(['controller' => 'RoleTypes', 'action' => 'add']);

        $this->assertResponseOk();

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->enableRetainFlashMessages();

        $this->post([
            'controller' => 'RoleTypes',
            'action' => 'add'
        ], [
            'role_type' => 'Assistant District Commissioner',
            'role_abbreviation' => 'ADC',
            'section_type_id' => 2,
            'level' => 3,
        ]);

        $this->assertRedirect(['controller' => 'RoleTypes', 'action' => 'view', 8]);
        $this->assertFlashElement('Flash/success');
        $this->assertFlashMessage('The role type has been saved.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @throws \PHPUnit\Exception
     */
    public function testEdit()
    {
        $this->login();

        $this->get(['controller' => 'RoleTypes', 'action' => 'edit', 1]);

        $this->assertResponseOk();

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->enableRetainFlashMessages();

        $this->configRequest([
            'environment' => ['HTTPS' => 'on']
        ]);

        $this->post([
            'controller' => 'RoleTypes',
            'action' => 'edit',
            1
        ], [
            'role_type' => 'District Commissioner',
            'role_abbreviation' => 'DC',
            'section_type_id' => 1,
            'level' => 1,
        ]);

        $this->assertRedirect(['controller' => 'RoleTypes', 'action' => 'view', 1]);
        $this->assertFlashElement('Flash/success');
        $this->assertFlashMessage('The role type has been saved.');
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
            'controller' => 'RoleTypes',
            'action' => 'delete',
            7
        ]);

        $this->assertRedirect(['controller' => 'RoleTypes', 'action' => 'index']);
        $this->assertFlashElement('Flash/success');
        $this->assertFlashMessage('The role type has been deleted.');
    }
}

<?php
namespace App\Test\TestCase\Controller;

use App\Controller\SectionTypesController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\SectionTypesController Test Case
 */
class SectionTypesControllerTest extends TestCase
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

        $this->get(['controller' => 'SectionTypes', 'action' => 'index']);

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

        $this->get(['controller' => 'SectionTypes', 'action' => 'view', 1]);

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

        $this->get(['controller' => 'SectionTypes', 'action' => 'add']);

        $this->assertResponseOk();

        $this->session([
            'Auth.User.id' => 1,
        ]);

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->enableRetainFlashMessages();

        $this->post([
            'controller' => 'SectionTypes',
            'action' => 'add'
        ], [
            'section_type' => 'Llamas'
        ]);

        $this->assertRedirect(['controller' => 'SectionTypes', 'action' => 'view', 9]);
        $this->assertFlashElement('Flash/success');
        $this->assertFlashMessage('The section type has been saved.');
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

        $this->get(['controller' => 'SectionTypes', 'action' => 'edit', 1]);

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
            'controller' => 'SectionTypes',
            'action' => 'edit',
            1
        ], [
            'section_type' => 'Llamas Kids'
        ]);

        $this->assertRedirect(['controller' => 'SectionTypes', 'action' => 'view', 1]);
        $this->assertFlashElement('Flash/success');
        $this->assertFlashMessage('The section type has been saved.');
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
            'Auth.User.id' => 1,
        ]);

        $this->enableCsrfToken();
        $this->enableSecurityToken();
        $this->enableRetainFlashMessages();

        $this->delete([
            'controller' => 'SectionTypes',
            'action' => 'delete',
            8
        ]);

        $this->assertRedirect(['controller' => 'SectionTypes', 'action' => 'index']);
        $this->assertFlashElement('Flash/success');
        $this->assertFlashMessage('The section type has been deleted.');
    }
}

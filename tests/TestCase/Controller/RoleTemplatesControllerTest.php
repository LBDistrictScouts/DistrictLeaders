<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Model\Entity\RoleTemplate;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\RoleTemplatesController Test Case
 *
 * @uses \App\Controller\RoleTemplatesController
 */
class RoleTemplatesControllerTest extends TestCase
{
    use AppTestTrait;

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
    ];

    /**
     * @var string $controller The Name of the controller being interrogated.
     */
    private $controller = 'RoleTemplates';

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->tryIndexGet($this->controller);
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->tryViewGet($this->controller);
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->tryAddGet($this->controller);

        $this->tryAddPost(
            $this->controller,
            [
                RoleTemplate::FIELD_ROLE_TEMPLATE => 'NEW TEMPLATE',
                RoleTemplate::FIELD_TEMPLATE_CAPABILITIES => ['ALL'],
                RoleTemplate::FIELD_INDICATIVE_LEVEL => 2,
            ],
            2
        );
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->tryEditGet($this->controller);

        $this->tryEditPost(
            $this->controller,
            [
                RoleTemplate::FIELD_ROLE_TEMPLATE => 'CHANGED TEMPLATE',
                RoleTemplate::FIELD_TEMPLATE_CAPABILITIES => ['ALL'],
                RoleTemplate::FIELD_INDICATIVE_LEVEL => 2,
            ],
            1
        );
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->tryDeletePost(
            $this->controller,
            [
                RoleTemplate::FIELD_ROLE_TEMPLATE => 'NEW TEMPLATE',
                RoleTemplate::FIELD_TEMPLATE_CAPABILITIES => ['ALL'],
                RoleTemplate::FIELD_INDICATIVE_LEVEL => 2,
            ],
            2
        );
    }
}

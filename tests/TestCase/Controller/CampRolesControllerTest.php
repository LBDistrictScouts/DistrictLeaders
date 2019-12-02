<?php
namespace App\Test\TestCase\Controller;

use App\Controller\CampRolesController;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\CampRolesController Test Case
 *
 * @uses \App\Controller\CampRolesController
 */
class CampRolesControllerTest extends TestCase
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
    ];

    /**
     * @var string $controller The Name of the controller being interrogated.
     */
    private $controller = 'CampRoles';

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
                'camp_id' => 1,
                'user_id' => 2,
                'camp_role_type_id' => 1
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
                'camp_id' => 1,
                'user_id' => 2,
                'camp_role_type_id' => 1
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
                'camp_id' => 1,
                'user_id' => 2,
                'camp_role_type_id' => 1
            ],
            2
        );
    }
}

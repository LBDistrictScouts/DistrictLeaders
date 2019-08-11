<?php
namespace App\Test\TestCase\Controller;

use App\Controller\RoleTypesController;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\RoleTypesController Test Case
 *
 * @uses \App\Controller\RoleTypesController
 */
class RoleTypesControllerTest extends TestCase
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
    private $controller = 'RoleTypes';

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
                'role_type' => 'Assistant Goat Commissioner',
                'role_abbreviation' => 'AGC',
                'section_type_id' => 1,
                'level' => 4,
            ],
            8
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
                'role_type' => 'District Commissioner',
                'role_abbreviation' => 'DC',
                'section_type_id' => 1,
                'level' => 1,
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
                'role_type' => 'Assistant District Commissioner',
                'role_abbreviation' => 'ADC',
                'section_type_id' => 2,
                'level' => 3,
            ],
            8
        );
    }
}

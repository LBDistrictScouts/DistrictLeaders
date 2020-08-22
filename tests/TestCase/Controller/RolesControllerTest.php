<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\TestCase;

/**
 * App\Controller\RolesController Test Case
 *
 * @uses \App\Controller\RolesController
 */
class RolesControllerTest extends TestCase
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
    ];

    /**
     * @var string $controller The Name of the controller being interrogated.
     */
    private $controller = 'Roles';

    /**
     * @param int|null $number The Redirect Array ID
     * @return array
     */
    private function retrieveAddRedirect(int $number = 10)
    {
        return [
            'controller' => $this->controller,
            'action' => 'edit',
            $number,
            '?' => [
                'contact' => true,
            ],
        ];
    }

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
                'role_type_id' => 6,
                'section_id' => 1,
                'user_id' => 2,
                'role_status_id' => 1,
            ],
            10,
            $this->retrieveAddRedirect()
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
                'role_type_id' => 6,
                'section_id' => 1,
                'user_id' => 2,
                'role_status_id' => 1,
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
                'role_type_id' => 6,
                'section_id' => 1,
                'user_id' => 2,
                'role_status_id' => 1,
            ],
            10,
            [
                'add' => $this->retrieveAddRedirect(),
                'delete' => null,
            ]
        );
    }
}

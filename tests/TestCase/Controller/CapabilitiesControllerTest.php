<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\TestCase;

/**
 * App\Controller\CapabilitiesController Test Case
 *
 * @uses \App\Controller\CapabilitiesController
 */
class CapabilitiesControllerTest extends TestCase
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
        'app.Sections',

        'app.RoleTemplates',
        'app.RoleTypes',
        'app.RoleStatuses',

        'app.Audits',
        'app.UserContactTypes',
        'app.UserContacts',

        'app.DirectoryTypes',
        'app.Directories',
        'app.DirectoryDomains',
        'app.DirectoryUsers',
        'app.DirectoryGroups',
        'app.RoleTypesDirectoryGroups',

        'app.Roles',

        'app.NotificationTypes',
        'app.Notifications',
    ];

    /**
     * @var string $controller The Name of the controller being interrogated.
     */
    private $controller = 'Capabilities';

    /**
     * @var array $validEntityData Valid creation Data.
     */
    private $validEntityData = [
        'capability_code' => 'TEST_NEW',
        'capability' => 'My Test Permissions',
        'min_level' => 5, // Config Level
    ];

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
            $this->validEntityData,
            7,
            [
                'controller' => $this->controller,
                'action' => 'edit',
                7,
                '?' => [
                    'roleTypes' => 1,
                ],
            ]
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
            $this->validEntityData,
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
            $this->validEntityData,
            7,
            [
                'add' => [
                    'controller' => $this->controller,
                    'action' => 'edit',
                    7,
                    '?' => [
                        'roleTypes' => 1,
                    ],
                ],
                'delete' => null,
            ]
        );
    }
}

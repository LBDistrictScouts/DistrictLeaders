<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\TestCase;

/**
 * App\Controller\UserStatesController Test Case
 *
 * @uses \App\Controller\UserStatesController
 */
class UserStatesControllerTest extends TestCase
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
        'app.NotificationTypes',
        'app.Notifications',
        'app.EmailSends',
        'app.Tokens',
        'app.EmailResponseTypes',
        'app.EmailResponses',

        'app.DirectoryTypes',
        'app.Directories',
        'app.DirectoryDomains',
        'app.DirectoryUsers',
        'app.DirectoryGroups',
        'app.RoleTypesDirectoryGroups',
    ];

    /**
     * @var string $controller The Name of the controller being interrogated.
     */
    private $controller = 'UserStates';

    /**
     * Test index method
     *
     * @return void
     * @throws
     */
    public function testIndex()
    {
        $this->tryIndexGet($this->controller);
    }

    /**
     * Test view method
     *
     * @return void
     * @throws
     */
    public function testView()
    {
        $this->tryViewGet($this->controller);
    }

    /**
     * Test add method
     *
     * @return void
     * @throws
     */
    public function testAdd()
    {
        $this->tryAddGet($this->controller);

        $this->tryAddPost(
            $this->controller,
            [
                'user_state' => 'New',
                'active' => true,
                'expired' => false,
            ],
            7
        );
    }

    /**
     * Test edit method
     *
     * @return void
     * @throws
     */
    public function testEdit()
    {
        $this->tryEditGet($this->controller);

        $this->tryEditPost(
            $this->controller,
            [
                'user_state' => 'Edited',
                'active' => true,
                'expired' => false,
            ],
            1
        );
    }

    /**
     * Test delete method
     *
     * @return void
     * @throws
     */
    public function testDelete()
    {
        $this->tryDeletePost(
            $this->controller,
            [
                'user_state' => 'For Deletion',
                'active' => true,
                'expired' => false,
            ],
            7
        );
    }
}

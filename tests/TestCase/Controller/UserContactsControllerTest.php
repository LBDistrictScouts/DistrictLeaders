<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\TestCase;

/**
 * App\Controller\UserContactsController Test Case
 *
 * @uses \App\Controller\UserContactsController
 */
class UserContactsControllerTest extends TestCase
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
    private $controller = 'UserContacts';

    /**
     * @var array $validEntityData Valid creation Data.
     */
    private $validEntityData = [
        'contact_field' => 'james@4thgoat.org.uk',
        'user_id' => 2,
        'user_contact_type_id' => 1,
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
            4
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
            4,
            [
                'add' => [
                    'controller' => 'UserContacts',
                    'action' => 'view',
                    4,
                ],
                'delete' => [
                    'controller' => 'Users',
                    'action' => 'view',
                    2,
                ],
            ],
            [
                'add' => 'The user contact has been saved.',
                'delete' => 'The user email "james@4thgoat.org.uk" has been deleted.',
            ]
        );
    }
}

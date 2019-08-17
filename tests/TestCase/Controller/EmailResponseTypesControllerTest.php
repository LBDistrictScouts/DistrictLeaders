<?php
namespace App\Test\TestCase\Controller;

use App\Controller\EmailResponseTypesController;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\EmailResponseTypesController Test Case
 *
 * @uses \App\Controller\EmailResponseTypesController
 */
class EmailResponseTypesControllerTest extends TestCase
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
        'app.CampRoleTypes',
        'app.CampRoles',
        'app.Camps',
        'app.CampTypes',
        'app.Notifications',
        'app.NotificationTypes',
        'app.EmailSends',
        'app.Tokens',
        'app.EmailResponseTypes',
        'app.EmailResponses',
    ];

    /**
     * @var string $controller The Name of the controller being interrogated.
     */
    private $controller = 'EmailResponseTypes';

    /**
     * @var array $validEntityData Valid creation Data.
     */
    private $validEntityData = [
        'email_response_type' => 'Email Send',
        'bounce' => false,
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
            2
        );
    }
}

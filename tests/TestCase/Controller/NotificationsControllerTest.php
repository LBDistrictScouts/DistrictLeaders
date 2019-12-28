<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\TestCase;

/**
 * App\Controller\NotificationsController Test Case
 *
 * @uses \App\Controller\NotificationsController
 */
class NotificationsControllerTest extends TestCase
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
    private $controller = 'Notifications';

    /**
     * @var array $validEntityData Valid creation Data.
     */
    private $validEntityData = [
        'user_id' => 1,
        'notification_type_id' => 1,
        'new' => false,
        'notification_header' => 'A payment has been recorded.',
        'text' => 'We have received a payment and have recorded it against your invoice. Please check that everything is in order.',
        'created' => '2018-02-25 15:56:43',
        'read_date' => '2018-02-25 15:58:04',
        'notification_source' => 'System Generated',
        'link_id' => 2,
        'link_controller' => 'Invoices',
        'link_prefix' => null,
        'link_action' => 'view',
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

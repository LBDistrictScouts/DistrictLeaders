<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\TestCase;

/**
 * App\Controller\EmailSendsController Test Case
 *
 * @uses \App\Controller\EmailSendsController
 */
class EmailSendsControllerTest extends TestCase
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
    private $controller = 'EmailSends';

    /**
     * @var array $validEntityData Valid creation Data.
     */
    private $validEntityData = [
        'email_generation_code' => 'USR-1-NEW',
        'email_template' => 'welcome',
        'include_token' => true,
        'sent' => null,
        'message_send_code' => 'PSJs821sxa928bs219SMZX9',
        'user_id' => 1,
        'subject' => 'Welcome User 1',
        'routing_domain' => 'routing.domain',
        'from_address' => 'hello@goat.com',
        'friendly_from' => 'The United Goat Federation',
        'notification_id' => 1,
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
     * Test send method
     *
     * @return void
     */
    public function testSend()
    {
        $this->markTestIncomplete('need a send');
    }

    /**
     * Test send method
     *
     * @return void
     */
    public function testMake()
    {
        $this->markTestIncomplete('need a make');
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
            null,
            2
        );
    }
}

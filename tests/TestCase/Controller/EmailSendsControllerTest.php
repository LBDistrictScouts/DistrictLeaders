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
     * @var string $controller The Name of the controller being interrogated.
     */
    private string $controller = 'EmailSends';

    /**
     * @var array $validEntityData Valid creation Data.
     */
    private array $validEntityData = [
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
    public function testIndex(): void
    {
        $this->tryIndexGet($this->controller);
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView(): void
    {
        $this->tryViewGet($this->controller);
    }

    /**
     * Test send method
     *
     * @return void
     */
    public function testSend(): void
    {
        $this->markTestIncomplete('need a send');
    }

    /**
     * Test send method
     *
     * @return void
     */
    public function testMake(): void
    {
        $this->markTestIncomplete('need a make');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit(): void
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
    public function testDelete(): void
    {
        $this->tryDeletePost(
            $this->controller,
            null,
            2
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\TestCase;

/**
 * App\Controller\EmailResponsesController Test Case
 *
 * @uses \App\Controller\EmailResponsesController
 */
class EmailResponsesControllerTest extends TestCase
{
    use AppTestTrait;

    /**
     * @var string $controller The Name of the controller being interrogated.
     */
    private string $controller = 'EmailResponses';

    /**
     * @var array $validEntityData Valid creation Data.
     */
    private array $validEntityData = [
        'email_send_id' => 1,
        'email_response_type_id' => 1,
        'link_clicked' => 'http://goat.com',
        'ip_address' => '192.168.1.1',
        'bounce_reason' => 'Fishing',
        'message_size' => 128,
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
     * Test add method
     *
     * @return void
     */
    public function testAdd(): void
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
            $this->validEntityData,
            2
        );
    }
}

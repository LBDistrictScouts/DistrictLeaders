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
     * @var string $controller The Name of the controller being interrogated.
     */
    private string $controller = 'Notifications';

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
     * Test delete method
     *
     * @return void
     */
    public function testDelete(): void
    {
        $this->tryDeletePost(
            $this->controller,
            null,
            1
        );
    }
}

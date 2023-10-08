<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\ControllerTestCase as TestCase;

/**
 * App\Controller\AdminController Test Case
 *
 * @uses \App\Controller\AdminController
 */
class AdminControllerTest extends TestCase
{
    use AppTestTrait;

    /**
     * @var string $controller The Name of the controller being interrogated.
     */
    private string $controller = 'Admin';

    /**
     * Test index method
     *
     * @return void
     */
    public function testStatus(): void
    {
        TestCase::markTestIncomplete();
        $this->tryGet(['controller' => $this->controller, 'action' => 'status']);
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testGoogle(): void
    {
        TestCase::markTestIncomplete();
        $this->tryGet(['controller' => $this->controller, 'action' => 'google']);
    }
}

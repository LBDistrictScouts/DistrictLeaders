<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\TestCase;

/**
 * App\Controller\AuditsController Test Case
 *
 * @uses \App\Controller\AuditsController
 */
class AuditsControllerTest extends TestCase
{
    use AppTestTrait;

    /**
     * @var string $controller The Name of the controller being interrogated.
     */
    private string $controller = 'Audits';

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
     * @throws
     */
    public function testView(): void
    {
        $this->login();

        $this->get(['controller' => 'Audits', 'action' => 'view', 1]);

        $this->assertRedirect(['controller' => 'Users', 'action' => 'view', 1]);
    }
}

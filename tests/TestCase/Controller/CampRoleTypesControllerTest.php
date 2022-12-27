<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\ControllerTestCase as TestCase;

/**
 * App\Controller\CampRoleTypesController Test Case
 *
 * @uses \App\Controller\CampRoleTypesController
 */
class CampRoleTypesControllerTest extends TestCase
{
    use AppTestTrait;

    /**
     * @var string $controller The Name of the controller being interrogated.
     */
    private string $controller = 'CampRoleTypes';

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
            [
                'camp_role_type' => 'Camp Leader',
            ],
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
            [
                'camp_role_type' => 'First Aider',
            ],
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
            [
                'camp_role_type' => 'Cook',
            ],
            2
        );
    }
}

<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\TestCase;

/**
 * App\Controller\CampRolesController Test Case
 *
 * @uses \App\Controller\CampRolesController
 */
class CampRolesControllerTest extends TestCase
{
    use AppTestTrait;

    /**
     * @var string $controller The Name of the controller being interrogated.
     */
    private string $controller = 'CampRoles';

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
                'camp_id' => 1,
                'user_id' => 2,
                'camp_role_type_id' => 1,
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
                'camp_id' => 1,
                'user_id' => 2,
                'camp_role_type_id' => 1,
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
                'camp_id' => 1,
                'user_id' => 2,
                'camp_role_type_id' => 1,
            ],
            2
        );
    }
}

<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\TestCase;

/**
 * App\Controller\ScoutGroupsController Test Case
 *
 * @uses \App\Controller\ScoutGroupsController
 */
class ScoutGroupsControllerTest extends TestCase
{
    use AppTestTrait;

    /**
     * @var string $controller The Name of the controller being interrogated.
     */
    private string $controller = 'ScoutGroups';

    /**
     * @var array $validEntityData Valid creation Data.
     */
    private array $validEntityData = [
        'scout_group' => '4th Goatville',
        'group_alias' => '4th Goat',
        'number_stripped' => 4,
        'charity_number' => 12345,
        'group_domain' => 'https://4thgoat.com',
    ];

    /**
     * Test index method
     *
     * @return void
     * @throws
     */
    public function testIndex(): void
    {
        $this->tryIndexGet($this->controller);
    }

    /**
     * Test index method
     *
     * @return void
     * @throws
     */
    public function testGenerate(): void
    {
        $actionArray = [
            'controller' => 'ScoutGroups',
            'action' => 'generate',
        ];

        $this->tryGet($actionArray);

        $dataArray = [

        ];

        $this->post($actionArray, $dataArray);
    }

    /**
     * Test view method
     *
     * @return void
     * @throws
     */
    public function testView(): void
    {
        $this->tryViewGet($this->controller);
    }

    /**
     * Test add method
     *
     * @return void
     * @throws
     */
    public function testAdd(): void
    {
        $this->tryAddGet($this->controller);

        $this->tryAddPost(
            $this->controller,
            $this->validEntityData,
            3
        );
    }

    /**
     * Test edit method
     *
     * @return void
     * @throws
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
     * @throws
     */
    public function testDelete(): void
    {
        $this->tryDeletePost(
            $this->controller,
            $this->validEntityData,
            3
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\TestCase;

/**
 * App\Controller\CampsController Test Case
 *
 * @uses \App\Controller\CampsController
 */
class CampsControllerTest extends TestCase
{
    use AppTestTrait;

    /**
     * @var string $controller The Name of the controller being interrogated.
     */
    private string $controller = 'Camps';

    /**
     * @var array $campData Valid creation Data.
     */
    private array $campData = [
        'camp_name' => 'Test New Camp',
        'camp_type_id' => 1,
        'camp_start' => [
            'year' => 2019,
            'month' => 8,
            'day' => 12,
            'hour' => 9,
            'minute' => 53,
        ],
        'camp_end' => [
            'year' => 2019,
            'month' => 8,
            'day' => 11,
            'hour' => 9,
            'minute' => 53,
        ],
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
            $this->campData,
            3
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
            $this->campData,
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
            $this->campData,
            3
        );
    }
}

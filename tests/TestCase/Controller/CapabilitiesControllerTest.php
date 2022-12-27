<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\TestSuite\TestCase;

/**
 * App\Controller\CapabilitiesController Test Case
 *
 * @uses \App\Controller\CapabilitiesController
 */
class CapabilitiesControllerTest extends TestCase
{
    use AppTestTrait;

    /**
     * @var string $controller The Name of the controller being interrogated.
     */
    private string $controller = 'Capabilities';

    /**
     * @var array $validEntityData Valid creation Data.
     */
    private array $validEntityData = [
        'capability_code' => 'TEST_NEW',
        'capability' => 'My Test Permissions',
        'min_level' => 5, // Config Level
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
            7,
            [
                'controller' => $this->controller,
                'action' => 'edit',
                7,
                '?' => [
                    'roleTypes' => 1,
                ],
            ]
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
            7,
            [
                'add' => [
                    'controller' => $this->controller,
                    'action' => 'edit',
                    7,
                    '?' => [
                        'roleTypes' => 1,
                    ],
                ],
                'delete' => null,
            ]
        );
    }
}

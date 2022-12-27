<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Model\Entity\Role;
use App\Test\TestCase\ControllerTestCase as TestCase;

/**
 * App\Controller\RolesController Test Case
 *
 * @uses \App\Controller\RolesController
 */
class RolesControllerTest extends TestCase
{
    /**
     * @var string $controller The Name of the controller being interrogated.
     */
    private string $controller = 'Roles';

    /**
     * @var array $validEntityData Valid creation Data.
     */
    private array $validEntityData = [
        Role::FIELD_ROLE_TYPE_ID => 6,
        Role::FIELD_SECTION_ID => 1,
        Role::FIELD_USER_ID => 2,
        Role::FIELD_ROLE_STATUS_ID => 1,
    ];

    /**
     * @return array
     */
    private function retrieveAddRedirect(): array
    {
        return [
            'controller' => $this->controller,
            'action' => 'edit',
            10,
            '?' => [
                'contact' => true,
            ],
        ];
    }

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
            10,
            $this->retrieveAddRedirect()
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
            10,
            [
                'add' => $this->retrieveAddRedirect(),
                'delete' => null,
            ]
        );
    }
}

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
    private $controller = 'Roles';

    /**
     * @var array $validEntityData Valid creation Data.
     */
    private $validEntityData = [
        Role::FIELD_ROLE_TYPE_ID => 6,
        Role::FIELD_SECTION_ID => 1,
        Role::FIELD_USER_ID => 2,
        Role::FIELD_ROLE_STATUS_ID => 1,
    ];

    /**
     * @param int|null $number The Redirect Array ID
     * @return array
     */
    private function retrieveAddRedirect(int $number = 10)
    {
        return [
            'controller' => $this->controller,
            'action' => 'edit',
            $number,
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
    public function testIndex()
    {
        $this->tryIndexGet($this->controller);
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->tryViewGet($this->controller);
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
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
    public function testEdit()
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
    public function testDelete()
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

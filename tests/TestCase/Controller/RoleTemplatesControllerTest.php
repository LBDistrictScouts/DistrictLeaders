<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Model\Entity\RoleTemplate;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\RoleTemplatesController Test Case
 *
 * @uses \App\Controller\RoleTemplatesController
 */
class RoleTemplatesControllerTest extends TestCase
{
    use AppTestTrait;

    /**
     * @var string $controller The Name of the controller being interrogated.
     */
    private string $controller = 'RoleTemplates';

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
                RoleTemplate::FIELD_ROLE_TEMPLATE => 'NEW TEMPLATE',
                RoleTemplate::FIELD_TEMPLATE_CAPABILITIES => ['ALL'],
                RoleTemplate::FIELD_INDICATIVE_LEVEL => 2,
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
                RoleTemplate::FIELD_ROLE_TEMPLATE => 'CHANGED TEMPLATE',
                RoleTemplate::FIELD_TEMPLATE_CAPABILITIES => ['ALL'],
                RoleTemplate::FIELD_INDICATIVE_LEVEL => 2,
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
                RoleTemplate::FIELD_ROLE_TEMPLATE => 'NEW TEMPLATE',
                RoleTemplate::FIELD_TEMPLATE_CAPABILITIES => ['ALL'],
                RoleTemplate::FIELD_INDICATIVE_LEVEL => 2,
            ],
            2
        );
    }
}

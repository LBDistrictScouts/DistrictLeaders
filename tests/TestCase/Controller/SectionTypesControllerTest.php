<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Model\Entity\SectionType;
use App\Test\TestCase\ControllerTestCase as TestCase;

/**
 * App\Controller\SectionTypesController Test Case
 *
 * @uses \App\Controller\SectionTypesController
 */
class SectionTypesControllerTest extends TestCase
{
    /**
     * @var string $controller The Name of the controller being interrogated.
     */
    private string $controller = 'SectionTypes';

    /**
     * @var array $validEntityData Valid creation Data.
     */
    private array $validEntityData = [
        SectionType::FIELD_SECTION_TYPE => 'Llamas',
        SectionType::FIELD_SECTION_TYPE_CODE => 'l',
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
            9
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
            9
        );
    }
}

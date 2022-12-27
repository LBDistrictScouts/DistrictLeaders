<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Model\Entity\DocumentType;
use App\Test\TestCase\ControllerTestCase as TestCase;

/**
 * App\Controller\DocumentTypesController Test Case
 *
 * @uses \App\Controller\DocumentTypesController
 */
class DocumentTypesControllerTest extends TestCase
{
    /**
     * @var string $controller The Name of the controller being interrogated.
     */
    private string $controller = 'DocumentTypes';

    /**
     * @var array $validEntityData Valid creation Data.
     */
    private array $validEntityData = [
        DocumentType::FIELD_DOCUMENT_TYPE => 'New Document Type',
        DocumentType::FIELD_SPECIAL_CAPABILITY => 'HISTORY',
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
            2
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Model\Entity\Document;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\DocumentsController Test Case
 *
 * @uses \App\Controller\DocumentsController
 */
class DocumentsControllerTest extends TestCase
{
    use AppTestTrait;

    /**
     * @var string $controller The Name of the controller being interrogated.
     */
    private string $controller = 'Documents';

    /**
     * @var array $validEntityData Valid creation Data.
     */
    private array $validEntityData = [
        Document::FIELD_DOCUMENT => 'My new document',
        Document::FIELD_DOCUMENT_TYPE_ID => 1,
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
        TestCase::markTestIncomplete();
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
        TestCase::markTestIncomplete();
        $this->tryDeletePost(
            $this->controller,
            $this->validEntityData,
            2
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Model\Entity\DocumentEdition;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\DocumentEditionsController Test Case
 *
 * @uses \App\Controller\DocumentEditionsController
 */
class DocumentEditionsControllerTest extends TestCase
{
    use AppTestTrait;

    /**
     * @var string $controller The Name of the controller being interrogated.
     */
    private string $controller = 'DocumentEditions';

    /**
     * @var array $validEntityData Valid creation Data.
     */
    private array $validEntityData = [
        DocumentEdition::FIELD_DOCUMENT_VERSION_ID => 1,
        DocumentEdition::FIELD_FILE_TYPE_ID => 2,
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
        $this->tryGet([
            'controller' => $this->controller,
            'action' => 'upload',
        ]);

        $this->tryPost(
            [
                'controller' => $this->controller,
                'action' => 'upload',
            ],
            $this->validEntityData,
            [
                'controller' => $this->controller,
                'action' => 'index',
            ]
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
        TestCase::markTestIncomplete();
        $this->tryDeletePost(
            $this->controller,
            $this->validEntityData,
            2
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Test\TestCase\View\Cell;

use App\View\Cell\AuthModalCell;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\TestSuite\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * App\View\Cell\AuthModalCell Test Case
 */
class AuthModalCellTest extends TestCase
{
    /**
     * Request mock
     *
     * @var ServerRequest|MockObject
     */
    protected ServerRequest|MockObject $request;

    /**
     * Response mock
     *
     * @var Response|MockObject
     */
    protected Response|MockObject $response;

    /**
     * Test subject
     *
     * @var AuthModalCell
     */
    protected AuthModalCell $AuthModal;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->request = $this->getMockBuilder('Cake\Http\ServerRequest')->getMock();
        $this->response = $this->getMockBuilder('Cake\Http\Response')->getMock();
        $this->AuthModal = new AuthModalCell($this->request, $this->response);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->AuthModal);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test display method
     *
     * @return void
     */
    public function testDisplay(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

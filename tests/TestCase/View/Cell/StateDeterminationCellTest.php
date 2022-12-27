<?php

declare(strict_types=1);

namespace App\Test\TestCase\View\Cell;

use App\View\Cell\StateDeterminationCell;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\TestSuite\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * App\View\Cell\StateDeterminationCell Test Case
 */
class StateDeterminationCellTest extends TestCase
{
    /**
     * Request mock
     *
     * @var MockObject|ServerRequest
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
     * @var StateDeterminationCell
     */
    protected StateDeterminationCell $StateDetermination;

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
        $this->StateDetermination = new StateDeterminationCell($this->request, $this->response);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->StateDetermination);

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

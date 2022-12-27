<?php

declare(strict_types=1);

namespace App\Test\TestCase\View\Cell;

use App\View\Cell\InformationCell;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\TestSuite\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * App\View\Cell\InformationCell Test Case
 */
class InformationCellTest extends TestCase
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
     * @var MockObject|Response
     */
    protected Response|MockObject $response;

    /**
     * Test subject
     *
     * @var InformationCell
     */
    protected InformationCell $Information;

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
        $this->Information = new InformationCell($this->request, $this->response);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Information);

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

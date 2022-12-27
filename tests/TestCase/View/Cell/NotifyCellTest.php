<?php

declare(strict_types=1);

namespace App\Test\TestCase\View\Cell;

use App\View\Cell\NotifyCell;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\TestSuite\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * App\View\Cell\NotifyCell Test Case
 */
class NotifyCellTest extends TestCase
{
    /**
     * Request mock
     *
     * @var ServerRequest|MockObject
     */
    public ServerRequest|MockObject $request;

    /**
     * Response mock
     *
     * @var Response|MockObject
     */
    public Response|MockObject $response;

    /**
     * Test subject
     *
     * @var NotifyCell
     */
    public NotifyCell $Notify;

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
        $this->Notify = new NotifyCell($this->request, $this->response);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Notify);

        parent::tearDown();
    }

    /**
     * Test display method
     *
     * @return void
     */
    public function testDisplay(): void
    {
        $this->Notify->display(1);

        $options = $this->Notify->viewBuilder()->getOptions();
        $expected = [];
        TestCase::assertEquals($expected, $options);
    }
}

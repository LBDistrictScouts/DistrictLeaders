<?php

declare(strict_types=1);

namespace App\Test\TestCase\View\Cell;

use App\Test\Fixture\FixtureTestTrait;
use App\View\Cell\ProfileModalCell;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\TestSuite\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * App\View\Cell\ProfileCell Test Case
 */
class ProfileModalCellTest extends TestCase
{
    use FixtureTestTrait;

    /**
     * Request mock
     *
     * @var MockObject|ServerRequest
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
     * @var ProfileModalCell
     */
    public ProfileModalCell $ProfileModal;

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
        $this->ProfileModal = new ProfileModalCell($this->request, $this->response);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ProfileModal);

        parent::tearDown();
    }

    /**
     * Test display method
     *
     * @return void
     */
    public function testDisplay()
    {
        $this->ProfileModal->display(1);

        $options = $this->ProfileModal->viewBuilder()->getOptions();
        $expected = [];
        TestCase::assertEquals($expected, $options);
    }
}

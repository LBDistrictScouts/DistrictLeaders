<?php

declare(strict_types=1);

namespace App\Test\TestCase\View\Cell;

use App\Test\Fixture\FixtureTestTrait;
use App\View\Cell\NavBarCell;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\TestSuite\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * App\View\Cell\NavBarCell Test Case
 */
class NavBarCellTest extends TestCase
{
    use FixtureTestTrait;

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
     * @var NavBarCell
     */
    public NavBarCell $NavBar;

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
        $this->NavBar = new NavBarCell($this->request, $this->response);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->NavBar);

        parent::tearDown();
    }

    /**
     * Test display method
     *
     * @return void
     */
    public function testDisplay()
    {
        $this->NavBar->display(1);

        $options = $this->NavBar->viewBuilder()->getOptions();
        $expected = [];
        TestCase::assertEquals($expected, $options);
    }
}

<?php
namespace App\Test\TestCase\View\Cell;

use App\View\Cell\NavBarCell;
use Cake\TestSuite\TestCase;

/**
 * App\View\Cell\NavBarCell Test Case
 */
class NavBarCellTest extends TestCase
{

    /**
     * Request mock
     *
     * @var \Cake\Http\ServerRequest|\PHPUnit_Framework_MockObject_MockObject
     */
    public $request;

    /**
     * Response mock
     *
     * @var \Cake\Http\Response|\PHPUnit_Framework_MockObject_MockObject
     */
    public $response;

    /**
     * Test subject
     *
     * @var \App\View\Cell\NavBarCell
     */
    public $NavBar;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Users',
        'app.RoleTypes',
        'app.RoleStatuses',
        'app.Sections',
        'app.SectionTypes',
        'app.ScoutGroups',
        'app.Audits',
        'app.Roles',
        'app.Capabilities',
        'app.CapabilitiesRoleTypes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
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
    public function tearDown()
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

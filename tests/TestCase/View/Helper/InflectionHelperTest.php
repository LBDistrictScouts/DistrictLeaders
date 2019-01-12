<?php
namespace App\Test\TestCase\View\Helper;

use App\View\Helper\InflectionHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\InflectionHelper Test Case
 */
class InflectionHelperTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\View\Helper\InflectionHelper
     */
    public $Inflection;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->Inflection = new InflectionHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Inflection);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testSpace()
    {
        $this->assertEquals('Scout Group', $this->Inflection->space('ScoutGroup'));
        $this->assertEquals('Scout Groups', $this->Inflection->space('ScoutGroups'));
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testSinglulariseSpace()
    {
        $this->assertEquals('Scout Group', $this->Inflection->singleSpace('ScoutGroups'));
        $this->assertEquals('Group', $this->Inflection->singleSpace('Groups'));
        $this->assertEquals('User Name', $this->Inflection->singleSpace('User_names'));
    }
}

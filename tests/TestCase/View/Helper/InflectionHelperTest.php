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
     * Provide data for Space Test
     *
     * @return array
     */
    public function provideSpaceData()
    {
        return [
            ['Scout Group', 'ScoutGroup'],
            ['Scout Groups', 'ScoutGroups'],
        ];
    }

    /**
     * Test initial setup
     *
     * @param string $expected The Value Expected
     * @param string $provided The Value Provided
     *
     * @dataProvider provideSpaceData
     *
     * @return void
     */
    public function testSpace($expected, $provided)
    {
        TestCase::assertEquals($expected, $this->Inflection->space($provided));
    }

    /**
     * Provide data for Space Test
     *
     * @return array
     */
    public function provideSpaceSingluarData()
    {
        return [
            ['Scout Group', 'ScoutGroups'],
            ['Group', 'Groups'],
            ['User Name', 'User_names'],
        ];
    }

    /**
     * Test initial setup
     *
     * @param string $expected The Value Expected
     * @param string $provided The Value Provided
     *
     * @dataProvider provideSpaceSingluarData
     *
     * @return void
     */
    public function testSinglulariseSpace($expected, $provided)
    {
        TestCase::assertEquals($expected, $this->Inflection->singleSpace($provided));
    }
}

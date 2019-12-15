<?php
namespace App\Test\TestCase\View\Helper;

use App\View\Helper\FunctionalHelper;
use Cake\Core\Configure;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\InflectionHelper Test Case
 */
class FunctionalHelperTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\View\Helper\FunctionalHelper
     */
    public $Functional;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->Functional = new FunctionalHelper($view);
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
    public function provideFunctionalAreaData()
    {
        $data = [];

        foreach (Configure::read('functionalAreas') as $item => $value) {
            array_push($data, [$value['enabled'], $item]);
        }

        array_push($data, [false, 'Cheeses']);

        return $data;
    }

    /**
     * Test initial setup
     *
     * @param string $expected The Value Expected
     * @param string $provided The Value Provided
     *
     * @dataProvider provideFunctionalAreaData
     *
     * @return void
     */
    public function testFunctionalArea($expected, $provided)
    {
        TestCase::assertEquals($expected, $this->Functional->checkFunction($provided));
    }

    /**
     * Provide data for Space Test
     *
     * @return array
     */
    public function provideSearchConfigData()
    {
        $data = [];

        foreach (Configure::read('searchConfigured') as $item => $value) {
            array_push($data, [$value, $item]);
        }

        array_push($data, [false, 'Cheeses']);

        return $data;
    }

    /**
     * Test initial setup
     *
     * @param string $expected The Value Expected
     * @param string $provided The Value Provided
     *
     * @dataProvider provideSearchConfigData
     *
     * @return void
     */
    public function testSearchConfigured($expected, $provided)
    {
        TestCase::assertEquals($expected, $this->Functional->checkSearchConfigured($provided));
    }
}

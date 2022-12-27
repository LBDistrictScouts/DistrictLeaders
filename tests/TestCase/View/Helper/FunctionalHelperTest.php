<?php

declare(strict_types=1);

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
     * @var FunctionalHelper
     */
    public $Functional;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
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
    public function tearDown(): void
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
        Configure::load('Application' . DS . 'functional_areas', 'yaml', false);

        foreach (Configure::read('FunctionalAreas') as $item => $value) {
            array_push($data, [$value['enabled'], $item]);
        }

        array_push($data, [false, 'Cheeses']);

        return $data;
    }

    /**
     * Test initial setup
     *
     * @param bool $expected The Value Expected
     * @param string $provided The Value Provided
     * @return void
     * @dataProvider provideFunctionalAreaData
     */
    public function testFunctionalArea(bool $expected, string $provided)
    {
        TestCase::assertEquals($expected, $this->Functional->checkFunctionEnabled($provided));
    }

    /**
     * Provide data for Space Test
     *
     * @return array
     */
    public function provideSearchConfigData()
    {
        $data = [];

        foreach (Configure::read('SearchConfigured') as $item => $value) {
            array_push($data, [$value, $item]);
        }

        array_push($data, [false, 'Cheeses']);

        return $data;
    }

    /**
     * Test initial setup
     *
     * @param bool $expected The Value Expected
     * @param string $provided The Value Provided
     * @return void
     * @dataProvider provideSearchConfigData
     */
    public function testSearchConfigured(bool $expected, string $provided)
    {
        TestCase::assertEquals($expected, $this->Functional->checkSearchConfigured($provided));
    }
}

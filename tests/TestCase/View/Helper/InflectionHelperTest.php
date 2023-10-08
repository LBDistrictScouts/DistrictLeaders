<?php
declare(strict_types=1);

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
     * @var InflectionHelper
     */
    public InflectionHelper $Inflection;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
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
    public function provideSpaceData(): array
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
     * @dataProvider provideSpaceData
     * @return void
     */
    public function testSpace(string $expected, string $provided): void
    {
        TestCase::assertEquals($expected, $this->Inflection->space($provided));
    }

    /**
     * Test null setup
     *
     * @return void
     */
    public function testNullSpace(): void
    {
        TestCase::assertEquals(null, $this->Inflection->space(null));
    }

    /**
     * Provide data for Space Test
     *
     * @return array
     */
    public function provideSpaceSingularData(): array
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
     * @dataProvider provideSpaceSingularData
     * @return void
     */
    public function testSingulariseSpace(string $expected, string $provided)
    {
        TestCase::assertEquals($expected, $this->Inflection->singleSpace($provided));
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testSingulariseNullSpace()
    {
        TestCase::assertEquals(null, $this->Inflection->singleSpace(null));
    }
}

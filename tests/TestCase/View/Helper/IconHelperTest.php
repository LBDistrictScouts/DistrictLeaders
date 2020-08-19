<?php
declare(strict_types=1);

namespace App\Test\TestCase\View\Helper;

use App\View\Helper\IconHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\IconHelper Test Case
 */
class IconHelperTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\View\Helper\IconHelper
     */
    protected $Icon;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $view = new View();
        $this->Icon = new IconHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Icon);

        parent::tearDown();
    }

    /**
     * Test iconStandard method
     *
     * @return void
     */
    public function testIconStandard(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    public function provideIconBoolean(): array
    {
        $result = $this->provideIconCheck();
        $expected = '<i class="fal fa-times"></i>';

        unset($result['False : ""']);
        $result['False : Times'] = [
            false,
            $expected,
        ];

        unset($result['Null : ""']);
        $result['Null : Times'] = [
            false,
            $expected,
        ];

        return $result;
    }

    /**
     * Test iconBoolean method
     *
     * @param bool|null $value The Test Input Value
     * @param string $expected The Expected HTML String
     * @dataProvider provideIconBoolean
     * @return void
     */
    public function testIconBoolean(?bool $value, string $expected): void
    {
        $result = $this->Icon->iconBoolean($value);
        TestCase::assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function provideIconCheck(): array
    {
        return [
            'True : Check' => [
                true,
                '<i class="fal fa-check"></i>',
            ],
            'False : ""' => [
                false,
                '',
            ],
            'Null : ""' => [
                null,
                '',
            ],
        ];
    }

    /**
     * Test iconCheck method
     *
     * @dataProvider provideIconCheck
     * @param bool|null $value The Test Input Value
     * @param string $expected The Expected HTML String
     * @return void
     */
    public function testIconCheck(?bool $value, string $expected): void
    {
        $result = $this->Icon->iconCheck($value);
        TestCase::assertEquals($expected, $result);
    }

    /**
     * Test iconHtml method
     *
     * @return void
     */
    public function testIconHtml(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test iconStandardEntity method
     *
     * @return void
     */
    public function testIconStandardEntity(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test iconHtmlEntity method
     *
     * @return void
     */
    public function testIconHtmlEntity(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

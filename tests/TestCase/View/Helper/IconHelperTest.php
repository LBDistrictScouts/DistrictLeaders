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

    public function provideIconStandard(): array
    {
        return [
            'Prefixed Sitemap' => [
                'fa-sitemap',
                'fal fa-sitemap',
            ],
            'Just Sitemap' => [
                'sitemap',
                'fal fa-sitemap',
            ],
        ];
    }

    /**
     * Test iconStandard method
     *
     * @param string|null $value The Value to be Parsed
     * @param string|null $expected The Expected Outcome
     * @dataProvider provideIconStandard
     * @return void
     */
    public function testIconStandard(?string $value, ?string $expected): void
    {
        $result = $this->Icon->iconStandard($value);
        TestCase::assertEquals($expected, $result);
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
     * @return array[]
     */
    public function provideIconHtml(): array
    {
        return [
            'Prefixed Sitemap' => [
                'fa-sitemap',
                '<i class="fal fa-sitemap"></i>',
            ],
            'Just Sitemap' => [
                'sitemap',
                '<i class="fal fa-sitemap"></i>',
            ],
        ];
    }

    /**
     * Test iconHtml method
     *
     * @dataProvider provideIconHtml
     * @param string $value
     * @param string $expected
     * @return void
     */
    public function testIconHtml(string $value, string $expected): void
    {
        $result = $this->Icon->iconHtml($value);
        TestCase::assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function provideStandardEntity(): array
    {
        return [
            'Standard' => [
                'Mushrooms',
                false,
            ],
            'Camps' => [
                'Camps',
                'fal fa-campground',
            ],
            'Directory' => [
                'Directory',
                'fal fa-address-card',
            ],
            'Documents' => [
                'Documents',
                'fal fa-file-alt',
            ],
            'Articles' => [
                'Articles',
                'fal fa-newspaper',
            ],
            'Users' => [
                'Users',
                'fal fa-users',
            ],
        ];
    }

    /**
     * Test iconStandardEntity method
     *
     * @dataProvider provideStandardEntity
     * @param string $value The value to be looked Up
     * @param string|false $expected The Expected Outcome
     * @return void
     */
    public function testIconStandardEntity(string $value, $expected): void
    {
        $result = $this->Icon->iconStandardEntity($value);
        TestCase::assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function provideHtmlEntity(): array
    {
        return [
            'Standard' => [
                'Mushrooms',
                false,
            ],
            'Camps' => [
                'Camps',
                '<i class="fal fa-campground"></i>',
            ],
            'Directory' => [
                'Directory',
                '<i class="fal fa-address-card"></i>',
            ],
            'Documents' => [
                'Documents',
                '<i class="fal fa-file-alt"></i>',
            ],
            'Articles' => [
                'Articles',
                '<i class="fal fa-newspaper"></i>',
            ],
            'Users' => [
                'Users',
                '<i class="fal fa-users"></i>',
            ],
        ];
    }

    /**
     * Test iconHtmlEntity method
     *
     * @dataProvider provideHtmlEntity
     * @param string $value The value to be looked Up
     * @param string|false $expected The Expected Outcome
     * @return void
     */
    public function testIconHtmlEntity(string $value, $expected): void
    {
        $result = $this->Icon->iconHtmlEntity($value);
        TestCase::assertEquals($expected, $result);
    }
}

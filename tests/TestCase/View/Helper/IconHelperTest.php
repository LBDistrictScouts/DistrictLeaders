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
    public $Icon;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
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
    public function tearDown()
    {
        unset($this->Icon);

        parent::tearDown();
    }

    /**
     * Test iconStandard method
     *
     * @return void
     */
    public function testIconStandard()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test iconHtml method
     *
     * @return void
     */
    public function testIconHtml()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test iconStandardEntity method
     *
     * @return void
     */
    public function testIconStandardEntity()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test iconHtmlEntity method
     *
     * @return void
     */
    public function testIconHtmlEntity()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

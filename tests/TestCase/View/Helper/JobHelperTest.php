<?php
declare(strict_types=1);

namespace App\Test\TestCase\View\Helper;

use App\View\Helper\JobHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\JobHelper Test Case
 */
class JobHelperTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\View\Helper\JobHelper
     */
    protected $JobHelper;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $view = new View();
        $this->JobHelper = new JobHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->JobHelper);

        parent::tearDown();
    }

    /**
     * Test tableFormat method
     *
     * @return void
     */
    public function testTableFormat(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test jobData method
     *
     * @return void
     */
    public function testJobData(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

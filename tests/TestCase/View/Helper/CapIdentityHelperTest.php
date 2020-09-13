<?php
declare(strict_types=1);

namespace App\Test\TestCase\View\Helper;

use App\View\Helper\CapIdentityHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\CapIdentityHelper Test Case
 */
class CapIdentityHelperTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\View\Helper\CapIdentityHelper
     */
    protected $CapIdentityHelper;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $view = new View();
        $this->CapIdentityHelper = new CapIdentityHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->CapIdentityHelper);

        parent::tearDown();
    }

    /**
     * Test checkCapability method
     *
     * @return void
     */
    public function testCheckCapability(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildAndCheckCapability method
     *
     * @return void
     */
    public function testBuildAndCheckCapability(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getName method
     *
     * @return void
     */
    public function testGetName(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

<?php

declare(strict_types=1);

namespace App\Test\TestCase\View\Helper;

use App\View\Helper\PermissionsHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\PermissionsHelper Test Case
 */
class PermissionsHelperTest extends TestCase
{
    /**
     * Test subject
     *
     * @var PermissionsHelper
     */
    protected $PermissionsHelper;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $view = new View();
        $this->PermissionsHelper = new PermissionsHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->PermissionsHelper);

        parent::tearDown();
    }

    /**
     * Test dropDownButton method
     *
     * @return void
     */
    public function testDropDownButton(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test button method
     *
     * @return void
     */
    public function testButton(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

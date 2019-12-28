<?php
declare(strict_types=1);

namespace App\Test\TestCase\Form;

use App\Form\GoogleAuthForm;
use Cake\TestSuite\TestCase;

/**
 * App\Form\GoogleAuthForm Test Case
 */
class GoogleAuthFormTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Form\GoogleAuthForm
     */
    public $GoogleAuth;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->GoogleAuth = new GoogleAuthForm();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->GoogleAuth);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

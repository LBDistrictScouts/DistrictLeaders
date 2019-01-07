<?php
namespace App\Test\TestCase\Form;

use App\Form\ResetForm;
use Cake\TestSuite\TestCase;

/**
 * App\Form\ResetForm Test Case
 */
class ResetFormTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Form\ResetForm
     */
    public $Reset;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Reset = new ResetForm();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Reset);

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

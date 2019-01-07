<?php
namespace App\Test\TestCase\Form;

use App\Form\PasswordForm;
use Cake\TestSuite\TestCase;

/**
 * App\Form\PasswordForm Test Case
 */
class PasswordFormTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Form\PasswordForm
     */
    public $Password;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Password = new PasswordForm();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Password);

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

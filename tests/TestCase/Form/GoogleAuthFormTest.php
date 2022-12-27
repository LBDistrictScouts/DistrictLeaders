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
     * @var GoogleAuthForm
     */
    public $GoogleAuth;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->GoogleAuth = new GoogleAuthForm();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->GoogleAuth);

        parent::tearDown();
    }

    /**
     * Test the Execution
     */
    public function testValidate()
    {
        $validationResult = $this->GoogleAuth->validate([
            GoogleAuthForm::FIELD_AUTH_CODE => 'Sai9akvuaus929sda',
        ]);

        TestCase::assertTrue($validationResult);
    }

    /**
     * Test the Execute Function
     *
     * @return void
     */
    public function testExecute()
    {
        TestCase::assertTrue($this->GoogleAuth->execute([]));
    }
}

<?php

declare(strict_types=1);

namespace App\Test\TestCase\Form;

use App\Form\ResetForm;
use App\Test\Fixture\FixtureTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Form\ResetForm Test Case
 */
class ResetFormTest extends TestCase
{
    use FixtureTestTrait;

    /**
     * Test subject
     *
     * @var ResetForm
     */
    public ResetForm $Reset;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->Reset = new ResetForm();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Reset);

        parent::tearDown();
    }

    /**
     * @return array
     */
    public function provideValidateData()
    {
        return [
            [ // 0 - Functional Pass - should be valid.
                123,
                'go@away.com',
                [
                    'validate_pass' => true,
                ],
                'Llama',
                'Fish',
            ],
            [ // 1 - Bad Email
                123,
                'goaycom',
                [
                    'validate_pass' => false,
                    'errorMessage' => 'Please Enter Valid Email Address.',
                    'errorFieldName' => ResetForm::FIELD_EMAIL,
                ],
                'Llama',
                'Fish',
            ],
            [ // 2 - Email Missing
                123,
                null,
                [
                    'validate_pass' => false,
                    'errorMessage' => 'This field cannot be left empty',
                    'errorFieldName' => ResetForm::FIELD_EMAIL,
                ],
                'Llama',
                'Fish',
            ],
            [ // 3 - Bad Membership Number
                'I_NOT_NUM',
                'go@away.com',
                [
                    'validate_pass' => false,
                    'errorMessage' => 'Please enter a valid TSA Membership Number.',
                    'errorFieldName' => ResetForm::FIELD_MEMBERSHIP_NUMBER,
                ],
                'Llama',
                'Fish',
            ],
            [ // 4 - Missing Membership Number
                null,
                'go@away.com',
                [
                    'validate_pass' => false,
                    'errorMessage' => 'This field cannot be left empty',
                    'errorFieldName' => ResetForm::FIELD_MEMBERSHIP_NUMBER,
                ],
                'Llama',
                'Fish',
            ],
            [ // 5 - Missing First Name - Pass
                123,
                'go@away.com',
                [
                    'validate_pass' => true,
                ],
                null,
                'Fish',
            ],
            [ // 6 - Empty First Name
                123,
                'go@away.com',
                [
                    'validate_pass' => false,
                    'errorMessage' => 'This field cannot be left empty',
                    'errorFieldName' => ResetForm::FIELD_FIRST_NAME,
                ],
                '',
                'Fish',
            ],
            [ // 7 - Missing Last Name - Pass
                123,
                'go@away.com',
                [
                    'validate_pass' => true,
                ],
                'Llama',
            ],
            [ // 8 - Empty Last Name
                123,
                'go@away.com',
                [
                    'validate_pass' => false,
                    'errorMessage' => 'This field cannot be left empty',
                    'errorFieldName' => ResetForm::FIELD_LAST_NAME,
                ],
                'Llama',
                '',
            ],
        ];
    }

    /**
     * Test initial setup
     *
     * @param int $membershipNumber The Membership Number
     * @param string $email The Email
     * @param array $outcome The error and error field etc
     * @param string|null $firstName The First Name
     * @param string|null $lastName The Last Name
     * @dataProvider provideValidateData
     * @return void
     */
    public function testValidate($membershipNumber, $email, $outcome, $firstName = null, $lastName = null)
    {
        $resultArray = [
            ResetForm::FIELD_MEMBERSHIP_NUMBER => $membershipNumber,
            ResetForm::FIELD_EMAIL => $email,
        ];

        if (!is_null($firstName)) {
            $resultArray = array_merge($resultArray, [ResetForm::FIELD_FIRST_NAME => $firstName]);
        }
        if (!is_null($lastName)) {
            $resultArray = array_merge($resultArray, [ResetForm::FIELD_LAST_NAME => $lastName]);
        }
        $results = $this->Reset->validate($resultArray);

        TestCase::assertEquals($outcome['validate_pass'], $results);

        if (!$results) {
            $errors = $this->Reset->getErrors();

            // Test Error Field
            $errorField = $outcome['errorFieldName'];
            TestCase::assertTrue(key_exists($errorField, $errors));

            // Check Message
            $errorFieldArray = $errors[$errorField];
            $error = $outcome['errorMessage'];
            TestCase::assertTrue(in_array($error, $errorFieldArray));
        }
    }
}

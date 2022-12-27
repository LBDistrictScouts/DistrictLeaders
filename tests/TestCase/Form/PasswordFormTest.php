<?php

declare(strict_types=1);

namespace App\Test\TestCase\Form;

use App\Form\PasswordForm;
use App\Model\Table\UsersTable;
use App\Test\TestCase\Controller\AppTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Form\PasswordForm Test Case
 */
class PasswordFormTest extends TestCase
{
    use AppTestTrait;

    /**
     * Test subject
     *
     * @var PasswordForm
     */
    public PasswordForm $Password;

    /**
     * Users Table
     *
     * @var UsersTable
     */
    public UsersTable $Users;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->Password = new PasswordForm();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Password);

        parent::tearDown();
    }

    /**
     * Provide Test Data for Test Execute
     *
     * @return array
     */
    public function provideValidateData()
    {
        return [
            ['MyNewPassword', 'DifferentPassword', 'LN9 0II',
                [
                    'passValidation' => false,
                    'errorMessage' => 'Passwords don\'t match',
                    'errorFieldName' => PasswordForm::FIELD_CONFIRM_PASSWORD,
                ],
            ],
            ['MyNewPassword', 'MyNewPassword', 'LN9',
                [
                    'passValidation' => false,
                    'errorMessage' => 'Postcode is too Short.',
                    'errorFieldName' => PasswordForm::FIELD_POSTCODE,
                ],
            ],
            ['MyNew', 'MyNew', 'LN9 0II',
                [
                    'passValidation' => false,
                    'errorMessage' => 'Password is too short.',
                    'errorFieldName' => PasswordForm::FIELD_NEW_PASSWORD,
                ],
            ],
            ['MyNewPassword', 'MyNewPassword', 'LN9 0II',
                [
                    'passValidation' => true,
                ],
            ],
        ];
    }

    /**
     * Test the Execution
     *
     * @param string $newPassword The New Password Field
     * @param string $confirmPassword The Old Password Field
     * @param string $postcode The User Password
     * @param array $outcome The Outcome Array
     * @dataProvider provideValidateData
     */
    public function testValidate(string $newPassword, string $confirmPassword, string $postcode, array $outcome)
    {
        $validationResult = $this->Password->validate([
            PasswordForm::FIELD_NEW_PASSWORD => $newPassword,
            PasswordForm::FIELD_CONFIRM_PASSWORD => $confirmPassword,
            PasswordForm::FIELD_POSTCODE => $postcode,
        ]);

        if (!$outcome['passValidation']) {
            TestCase::assertFalse($validationResult);

            // Check Errors
            $errors = $this->Password->getErrors();

            // Test Error Field
            $errorField = $outcome['errorFieldName'];
            TestCase::assertTrue(key_exists($errorField, $errors));

            // Check Message
            $errorFieldArray = $errors[$errorField];
            $error = $outcome['errorMessage'];
            TestCase::assertTrue(in_array($error, $errorFieldArray));
        } else {
            TestCase::assertTrue($validationResult);
        }
    }

    /**
     * @return array
     */
    public function provideExecuteData()
    {
        $postcode = 'LN9 0II';

        return [
            '0 - Correct Data Pass' => [
                [
                    'user' => true,
                    'request' => [
                        PasswordForm::FIELD_NEW_PASSWORD => 'MyNewPassword',
                        PasswordForm::FIELD_CONFIRM_PASSWORD => 'MyNewPassword',
                        PasswordForm::FIELD_POSTCODE => $postcode,
                    ],
                ], // Execute Request Array
                true,
            ],
            '1 - Pass for lower case Postcode' => [
                [
                    'user' => true,
                    'request' => [
                        PasswordForm::FIELD_NEW_PASSWORD => 'MyNewPassword',
                        PasswordForm::FIELD_CONFIRM_PASSWORD => 'MyNewPassword',
                        PasswordForm::FIELD_POSTCODE => strtolower($postcode),
                    ],
                ], // Execute Request Array
                true,
            ],
            '2 - Fail unmatched password' => [
                [
                    'user' => true,
                    'request' => [
                        PasswordForm::FIELD_NEW_PASSWORD => 'MyNewPassword',
                        PasswordForm::FIELD_CONFIRM_PASSWORD => 'Goat',
                        PasswordForm::FIELD_POSTCODE => $postcode,
                    ],
                ], // Execute Request Array
                false,
            ],
            '3 - Missing Request' => [
                [
                    'user' => true,
                ], // Execute Request Array
                false,
            ],
            '4 - Missing User' => [
                [
                    'request' => [
                        PasswordForm::FIELD_NEW_PASSWORD => 'MyNewPassword',
                        PasswordForm::FIELD_CONFIRM_PASSWORD => 'MyNewPassword',
                        PasswordForm::FIELD_POSTCODE => $postcode,
                    ],
                ], // Execute Request Array
                false,
            ],
            '5 - Missing New Password' => [
                [
                    'user' => true,
                    'request' => [
                        PasswordForm::FIELD_CONFIRM_PASSWORD => 'MyNewPassword',
                        PasswordForm::FIELD_POSTCODE => $postcode,
                    ],
                ], // Execute Request Array
                false,
            ],
            '6 - Missing Confirm Password' => [
                [
                    'user' => true,
                    'request' => [
                        PasswordForm::FIELD_NEW_PASSWORD => 'MyNewPassword',
                        PasswordForm::FIELD_POSTCODE => $postcode,
                    ],
                ], // Execute Request Array
                false,
            ],
            '7 - Missing Postcode' => [
                [
                    'user' => true,
                    'request' => [
                        PasswordForm::FIELD_NEW_PASSWORD => 'MyNewPassword',
                        PasswordForm::FIELD_CONFIRM_PASSWORD => 'Goat',
                    ],
                ], // Execute Request Array
                false,
            ],
        ];
    }

    /**
     * Test the Execute Function
     *
     * @param array $requestArray Array for Request
     * @param bool $outcome Expected Outcome
     * @return void
     * @dataProvider provideExecuteData
     */
    public function testExecute(array $requestArray, bool $outcome)
    {
        if (key_exists('user', $requestArray) && $requestArray['user']) {
            $this->Users = $this->getTableLocator()->get('Users');
            $user = $this->Users->get(2);
            $requestArray['request']['user'] = $user;
        }

        $result = $this->Password->execute($requestArray['request']);

        TestCase::assertEquals($outcome, $result);
    }
}

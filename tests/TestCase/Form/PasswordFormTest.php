<?php
namespace App\Test\TestCase\Form;

use App\Form\PasswordForm;
use App\Model\Entity\User;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Form\PasswordForm Test Case
 */
class PasswordFormTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Test subject
     *
     * @var \App\Form\PasswordForm
     */
    public $Password;

    /**
     * Users Table
     *
     * @var \App\Model\Table\UsersTable
     */
    public $Users;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PasswordStates',
        'app.Users',
        'app.CapabilitiesRoleTypes',
        'app.Capabilities',
        'app.ScoutGroups',
        'app.SectionTypes',
        'app.RoleTemplates',
        'app.RoleTypes',
        'app.RoleStatuses',
        'app.Sections',
        'app.Audits',
        'app.UserContactTypes',
        'app.UserContacts',
        'app.Roles',
        'app.CampRoleTypes',
        'app.CampRoles',
        'app.Camps',
        'app.CampTypes',
        'app.Notifications',
        'app.NotificationTypes',
        'app.EmailSends',
        'app.Tokens',
        'app.EmailResponseTypes',
        'app.EmailResponses',
    ];

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
     *
     * @dataProvider provideValidateData
     */
    public function testValidate($newPassword, $confirmPassword, $postcode, $outcome)
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
            [ // 0 - Correct Data Pass
                [
                    'user' => true,
                    'request' => [
                        PasswordForm::FIELD_NEW_PASSWORD => 'MyNewPassword',
                        PasswordForm::FIELD_CONFIRM_PASSWORD => 'MyNewPassword',
                        PasswordForm::FIELD_POSTCODE => $postcode,
                    ],
                ], // Execute Request Array
                [
                    'execute_pass' => true,
                ], // Outcome Array
            ],
            [ // 1 - Pass for lower case Postcode
                [
                    'user' => true,
                    'request' => [
                        PasswordForm::FIELD_NEW_PASSWORD => 'MyNewPassword',
                        PasswordForm::FIELD_CONFIRM_PASSWORD => 'MyNewPassword',
                        PasswordForm::FIELD_POSTCODE => strtolower($postcode),
                    ],
                ], // Execute Request Array
                [
                    'execute_pass' => true,
                ], // Outcome Array
            ],
            [ // 2 - Fail unmatched password
                [
                    'user' => true,
                    'request' => [
                        PasswordForm::FIELD_NEW_PASSWORD => 'MyNewPassword',
                        PasswordForm::FIELD_CONFIRM_PASSWORD => 'Goat',
                        PasswordForm::FIELD_POSTCODE => $postcode,
                    ],
                ], // Execute Request Array
                [
                    'execute_pass' => false,
                ], // Outcome Array
            ],
            [ // 3 - Missing Request
                [
                    'user' => true,
                ], // Execute Request Array
                [
                    'execute_pass' => false,
                ], // Outcome Array
            ],
            [ // 4 - Missing User
                [
                    'request' => [
                        PasswordForm::FIELD_NEW_PASSWORD => 'MyNewPassword',
                        PasswordForm::FIELD_CONFIRM_PASSWORD => 'MyNewPassword',
                        PasswordForm::FIELD_POSTCODE => $postcode,
                    ],
                ], // Execute Request Array
                [
                    'execute_pass' => false,
                ], // Outcome Array
            ],
            [ // 5 - Missing New Password
                [
                    'user' => true,
                    'request' => [
                        PasswordForm::FIELD_CONFIRM_PASSWORD => 'MyNewPassword',
                        PasswordForm::FIELD_POSTCODE => $postcode,
                    ],
                ], // Execute Request Array
                [
                    'execute_pass' => false,
                ], // Outcome Array
            ],
            [ // 6 - Missing Confirm Password
                [
                    'user' => true,
                    'request' => [
                        PasswordForm::FIELD_NEW_PASSWORD => 'MyNewPassword',
                        PasswordForm::FIELD_POSTCODE => $postcode,
                    ],
                ], // Execute Request Array
                [
                    'execute_pass' => false,
                ], // Outcome Array
            ],
            [ // 7 - Missing Postcode
                [
                    'user' => true,
                    'request' => [
                        PasswordForm::FIELD_NEW_PASSWORD => 'MyNewPassword',
                        PasswordForm::FIELD_CONFIRM_PASSWORD => 'Goat',
                    ],
                ], // Execute Request Array
                [
                    'execute_pass' => false,
                ], // Outcome Array
            ],
        ];
    }

    /**
     * Test the Execute Function
     *
     * @param array $requestArray
     * @param array $outcomeArray
     *
     * @dataProvider provideExecuteData
     *
     * @return void
     */
    public function testExecute($requestArray, $outcomeArray)
    {
        if (key_exists('user', $requestArray) && $requestArray['user']) {
            $this->Users = TableRegistry::getTableLocator()->get('Users');
            $user = $this->Users->get(2);
            $requestArray['user'] = $user;
        }

        $result = $this->Password->execute($requestArray);

        TestCase::assertEquals($outcomeArray['execute_pass'], $result);
    }
}

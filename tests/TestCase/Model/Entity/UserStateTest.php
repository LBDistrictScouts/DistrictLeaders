<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Entity;

use App\Model\Entity\User;
use App\Model\Entity\UserState;
use App\Test\TestCase\Controller\AppTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Entity\User Test Case
 *
 * @property \App\Model\Table\UsersTable $Users
 * @property \App\Model\Table\UserStatesTable $UserStates
 */
class UserStateTest extends TestCase
{
    use AppTestTrait;

    /**
     * Test subject
     *
     * @var \App\Model\Entity\User
     */
    public $User;

    /**
     * Test subject
     *
     * @var \App\Model\Entity\UserState
     */
    public $UserState;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.UserStates',
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
        'app.CampTypes',
        'app.Camps',
        'app.CampRoleTypes',
        'app.CampRoles',
        'app.NotificationTypes',
        'app.Notifications',
        'app.EmailSends',
        'app.Tokens',
        'app.EmailResponseTypes',
        'app.EmailResponses',
        'app.DirectoryTypes',
        'app.Directories',
        'app.DirectoryDomains',
        'app.DirectoryUsers',
        'app.DirectoryGroups',
        'app.RoleTypesDirectoryGroups',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->User = new User();
        $this->UserState = new UserState();
        $this->Users = $this->getTableLocator()->get('Users');
        $this->UserStates = $this->getTableLocator()->get('UserStates');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->User);
        unset($this->UserState);
        unset($this->Users);
        unset($this->UserStates);

        parent::tearDown();
    }

    public function provideEvaluatedConstants()
    {
        return [
            'Username' => [
                'EVALUATE_USERNAME',
                1,
            ],
            'Login Ever' => [
                'EVALUATE_LOGIN_EVER',
                2,
            ],
            'Login Quarter' => [
                'EVALUATE_LOGIN_QUARTER',
                4,
            ],
            'Login Cap' => [
                'EVALUATE_LOGIN_CAPABILITY',
                8,
            ],
            'Active Role' => [
                'EVALUATE_ACTIVE_ROLE',
                16,
            ],
        ];
    }

    /**
     * @param string $constantName Name of the Constant
     * @param int $expected Binary Value as an Integer
     * @dataProvider provideEvaluatedConstants
     */
    public function testEvaluateConstants($constantName, $expected)
    {
        $actual = constant(UserState::class . '::' . $constantName);
        TestCase::assertEquals($expected, $actual);
    }
}

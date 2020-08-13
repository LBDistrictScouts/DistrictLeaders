<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\User;
use App\Model\Entity\UserState;
use App\Model\Table\UsersTable;
use App\Model\Table\UserStatesTable;
use Cake\I18n\FrozenTime;
use Cake\TestSuite\TestCase;
use Cake\Utility\Inflector;

/**
 * App\Model\Table\UserStatesTable Test Case
 */
class UserStatesTableTest extends TestCase
{
    use ModelTestTrait;

    /**
     * Test subject
     *
     * @var \App\Model\Table\UserStatesTable
     */
    private $UserStates;

    /**
     * Test subject
     *
     * @var \App\Model\Table\UsersTable
     */
    private $Users;

    /**
     * Test subject
     *
     * @var \App\Model\Entity\User
     */
    private $User;

    /**
     * Test subject
     *
     * @var \App\Model\Entity\UserState
     */
    private $UserState;

    /**
     * @var string[]
     */
    private $cases = [
        'EVALUATE_USERNAME',
        'EVALUATE_LOGIN_EVER',
        'EVALUATE_LOGIN_QUARTER',
        'EVALUATE_LOGIN_CAPABILITY',
        'EVALUATE_ACTIVE_ROLE',
        'EVALUATE_VALIDATED_EMAIL',
    ];

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
        $config = $this->getTableLocator()->exists('UserStates') ? [] : ['className' => UserStatesTable::class];
        $this->UserStates = $this->getTableLocator()->get('UserStates', $config);

        $config = $this->getTableLocator()->exists('Users') ? [] : ['className' => UsersTable::class];
        $this->Users = $this->getTableLocator()->get('Users', $config);

        $now = new FrozenTime('2020-06-01 00:01:00');
        FrozenTime::setTestNow($now);

        $this->User = new User();
        $this->UserState = new UserState();
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

    /**
     * Get Good Set Function
     *
     * @return array
     * @throws
     */
    private function getGood()
    {
        $good = [
            'user_state' => 'Status ' . random_int(111, 999) . ' ' . random_int(111, 999),
            'active' => true,
            'expired' => false,
        ];

        return $good;
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $expected = [
            'id' => 1,
            'user_state' => 'Lorem ipsum dolor sit amet',
            'active' => true,
            'expired' => true,
        ];
        $this->validateInitialise($expected, $this->UserStates, 1);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $good = $this->getGood();

        $new = $this->UserStates->newEntity($good);
        TestCase::assertInstanceOf('App\Model\Entity\UserState', $this->UserStates->save($new));

        $required = [
            'user_state',
            'active',
            'expired',
        ];
        $this->validateRequired($required, $this->UserStates, [$this, 'getGood']);

        $notEmpties = [
            'user_state',
            'active',
            'expired',
        ];
        $this->validateNotEmpties($notEmpties, $this->UserStates, [$this, 'getGood']);

        $maxLengths = [
            'user_state' => 255,
        ];
        $this->validateMaxLengths($maxLengths, $this->UserStates, [$this, 'getGood']);
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->validateUniqueRule(UserState::FIELD_USER_STATE, $this->UserStates, [$this, 'getGood']);
    }

    /**
     * Test installBaseStatuses method
     *
     * @return void
     */
    public function testInstallBaseTypes()
    {
        $this->validateInstallBase($this->UserStates);
    }

    /**
     * @return array
     */
    public function provideEvaluationData(): array
    {
        $return = [];
        $user = new User();

        foreach ($this->cases as $case) {
            $name = ucwords(strtolower(Inflector::humanize(str_replace('EVALUATE_', '', $case))));
            $negativeUser = new User();

            if ($case == 'EVALUATE_LOGIN_QUARTER') {
                $lastLogin = new FrozenTime('2020-06-01 00:01:00');
                $lastLogin = $lastLogin->subMonths(6);
                $user = $user->set(User::FIELD_LAST_LOGIN, $lastLogin);
            }

            $return['Not ' . $name] = [$case, $negativeUser, false];

            switch ($case) {
                case 'EVALUATE_USERNAME':
                    $user = $user->set(User::FIELD_USERNAME, 'RandomFish');
                    break;
                case 'EVALUATE_LOGIN_CAPABILITY':
                    $userTestData = [
                        User::FIELD_CAPABILITIES => [
                            'user' => ['LOGIN'],
                            'group' => [
                                1 => ['BLAH-NOT-A-REAL-KEY'],
                                9 => ['BLAH-NOT-A-REAL-KEY'],
                            ],
                            'section' => [
                                4 => ['BLAH-NOT-A-REAL-KEY'],
                                8 => ['BLAH-NOT-A-REAL-KEY'],
                            ],
                        ],
                    ];
                    $user = new User($userTestData, ['validate' => false]);
                    break;
                case 'EVALUATE_ACTIVE_ROLE':
                    $user = $user->set(User::FIELD_ACTIVE_ROLE_COUNT, 1);
                    break;
                case 'EVALUATE_VALIDATED_EMAIL':
                    $user = $user->set(User::FIELD_VALIDATED_EMAIL_COUNT, 1);
                    break;
                case 'EVALUATE_LOGIN_QUARTER':
                case 'EVALUATE_LOGIN_EVER':
                    $lastLogin = new FrozenTime('2020-06-01 00:01:00');
                    $lastLogin = $lastLogin->subDays(10);
                    $user = $user->set(User::FIELD_LAST_LOGIN, $lastLogin);
                    break;
                default:
                    break;
            }

            $return[$name] = [$case, $user, true];
        }

        return $return;
    }

    public function testProvider()
    {
        $array = $this->provideEvaluationData();
        TestCase::assertIsArray($array);

        $expected = count($this->cases) * 2;
        TestCase::assertEquals($expected, count($array));

        foreach ($array as $item) {
            TestCase::assertIsArray($item);
            TestCase::assertIsString($item[0]);
            TestCase::assertInstanceOf(User::class, $item[1]);
            TestCase::assertIsBool($item[2]);
        }
    }

    /**
     * @param string $evaluation Binary Mask Expectation
     * @param User $user Known User to be Evaluated
     * @param bool $expected The Outcome Expected
     * @dataProvider provideEvaluationData
     */
    public function testEvaluateUser(string $evaluation, User $user, bool $expected): void
    {
        TestCase::assertIsString($evaluation);
        TestCase::assertInstanceOf(User::class, $user);
        TestCase::assertIsBool($expected);

        $result = $this->UserStates->evaluateUser($user);
        $mask = (bool)(($result & constant(UserState::class . '::' . $evaluation)) > 0);
        TestCase::assertEquals($expected, $mask);
    }
}

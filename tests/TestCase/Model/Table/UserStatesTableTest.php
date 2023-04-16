<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\User;
use App\Model\Entity\UserState;
use App\Model\Table\Traits\BaseInstallerTrait;
use App\Model\Table\UsersTable;
use App\Model\Table\UserStatesTable;
use Cake\I18n\FrozenTime;
use Cake\TestSuite\TestCase;
use Cake\Utility\Inflector;
use Exception;
use Faker\Factory;

/**
 * App\Model\Table\UserStatesTable Test Case
 */
class UserStatesTableTest extends TestCase
{
    use ModelTestTrait;
    use BaseInstallerTrait;

    /**
     * Test subject
     *
     * @var UserStatesTable
     */
    protected UserStatesTable $UserStates;

    /**
     * Test subject
     *
     * @var UsersTable
     */
    protected UsersTable $Users;

    /**
     * Test subject
     *
     * @var User
     */
    protected User $User;

    /**
     * Test subject
     *
     * @var UserState
     */
    protected UserState $UserState;

    /**
     * @var string[]
     */
    protected $cases = [
        'EVALUATE_USERNAME',
        'EVALUATE_LOGIN_EVER',
        'EVALUATE_LOGIN_QUARTER',
        'EVALUATE_LOGIN_CAPABILITY',
        'EVALUATE_ACTIVE_ROLE',
        'EVALUATE_VALIDATED_EMAIL',
        'EVALUATE_ACTIVATED',
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
    private function getGood(): array
    {
        $faker = Factory::create('en_GB');

        return [
            'user_state' => ucwords($faker->words(2, true)),
            'active' => true,
            'expired' => false,
        ];
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize(): void
    {
        $expected = [
            UserState::FIELD_ID => 1,
            UserState::FIELD_USER_STATE => 'Active Directory User',
            UserState::FIELD_ACTIVE => true,
            UserState::FIELD_EXPIRED => false,
            UserState::FIELD_PRECEDENCE_ORDER => 1,
            UserState::FIELD_SIGNATURE => 63,
            UserState::FIELD_IS_EMAIL_SEND_ACTIVE => true,
        ];

        $this->validateInitialise($expected, $this->UserStates, 6);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
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
    public function testBuildRules(): void
    {
        $this->validateUniqueRule(UserState::FIELD_USER_STATE, $this->UserStates, [$this, 'getGood']);
    }

    /**
     * Test installBaseUserStates method
     *
     * @return void
     */
    public function testInstallBaseUserStates(): void
    {
        $this->validateInstallBase($this->UserStates);
    }

    /**
     * Test installBaseUserStates method
     *
     * @return void
     */
    public function testInstallBaseUserStateSignatures(): void
    {
        $result = $this->UserStates->installBaseUserStates();
        $values = $this->getBaseValues($this->UserStates);
        TestCase::assertEquals(count($values), $result);

        foreach ($values as $baseState) {
            /** @var UserState $installedState */
            $installedState = $this->UserStates
                ->find()
                ->where([UserState::FIELD_USER_STATE => $baseState[UserState::FIELD_USER_STATE]])
                ->first();

            $expectedSignature = $this->UserStates->evaluateSignature($baseState['required']);

            TestCase::assertInstanceOf(
                UserState::class,
                $installedState,
                __('State: {0} not installed.', $baseState[UserState::FIELD_USER_STATE])
            );
            TestCase::assertEquals($expectedSignature, $installedState->signature);
        }
    }

    /**
     * @return array
     */
    public function provideRandomSignature(): array
    {
        $caseCount = count($this->cases);
        $binMax = 2 ** $caseCount;
        $pos = 0;
        $return = [];

        while ($pos <= 10) {
            try {
                $randKey = random_int(0, $binMax - 1);
            } catch (Exception $e) {
                $randKey = 5;
            }
            $applicableCases = [];

            foreach ($this->cases as $case) {
                $binValue = constant(UserState::class . '::' . $case);
                if ($randKey & $binValue) {
                    array_push($applicableCases, $case);
                }
            }

            $index = 'Random Key Value ' . $randKey;

            $return[$index] = [
                $applicableCases,
                $randKey,
            ];
            $pos++;
        }

        return $return;
    }

    /**
     * Test evaluationSignatures method
     *
     * @dataProvider provideRandomSignature
     * @param array $applicableCases Array of Boolean Constants
     * @param int $expectedSignature Signature Expected to be Derived
     * @return void
     */
    public function testEvaluationSignatures(array $applicableCases, int $expectedSignature): void
    {
        $state = new UserState();
        $state = $this->UserStates->evaluationSignatures($state, $applicableCases);

        TestCase::assertEquals($expectedSignature, $state->signature);
    }

    /**
     * @return void
     */
    public function testEvaluateSignatureProvider(): void
    {
        $result = $this->provideRandomSignature();
        TestCase::assertIsArray($result);
    }

    /**
     * Test evaluationSignatures method
     *
     * @dataProvider provideRandomSignature
     * @param array $applicableCases Array of Boolean Constants
     * @param int $expectedSignature Signature Expected to be Derived
     * @return void
     */
    public function testEvaluateSignature(array $applicableCases, int $expectedSignature): void
    {
        TestCase::assertEquals($expectedSignature, $this->UserStates->evaluateSignature($applicableCases));
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
                case 'EVALUATE_ACTIVATED':
                    $user->set(User::FIELD_ACTIVATED, true);
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

    /**
     * @return int[][]
     */
    public function provideBaseSignatureState()
    {
        return [
            'Active Directory User' => [
                127,
                1,
            ],
            'Provisional User' => [
                79,
                2,
            ],
            'Prevalidation' => [
                89,
                3,
            ],
            'Invited User' => [
                80,
                4,
            ],
            'Inactive User' => [
                107,
                5,
            ],
            'Draft User' => [
                0,
                7,
            ],
        ];
    }

    /**
     * @return int[][]
     */
    public function provideDetermineSignatureState()
    {
        $data = $this->provideBaseSignatureState();

        foreach ($data as $index => $datum) {
            $newIndex = 'Modified ' . $index;

            $signature = $datum[0];
            if ($signature == 107) {
                continue;
            }

            $signature |= UserState::EVALUATE_LOGIN_QUARTER;
            $data[$newIndex] = [$signature, $datum[1]];
        }

        return $data;
    }

    /**
     * @param int $signature Binary Mask Signature
     * @param int $stateExpectedId The Outcome State Expected
     * @dataProvider provideDetermineSignatureState
     */
    public function testDetermineSignatureState(int $signature, int $stateExpectedId): void
    {
        $this->UserStates->installBaseUserStates();

        $result = $this->UserStates->determineSignatureState($signature);
        TestCase::assertEquals($stateExpectedId, $result->id);
    }
}

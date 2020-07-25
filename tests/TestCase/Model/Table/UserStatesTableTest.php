<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\UserState;
use App\Model\Table\UserStatesTable;
use Cake\TestSuite\TestCase;

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
    public $UserStates;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.UserStates',
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
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
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
}

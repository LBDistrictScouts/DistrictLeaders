<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\UserContactType;
use App\Model\Table\UserContactTypesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UserContactTypesTable Test Case
 */
class UserContactTypesTableTest extends TestCase
{
    use ModelTestTrait;

    /**
     * Test subject
     *
     * @var \App\Model\Table\UserContactTypesTable
     */
    public $UserContactTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.UserContactTypes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('UserContactTypes') ? [] : ['className' => UserContactTypesTable::class];
        $this->UserContactTypes = $this->getTableLocator()->get('UserContactTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->UserContactTypes);

        parent::tearDown();
    }

    /**
     * Get Good Set Function
     *
     * @return array
     * @throws \Exception
     */
    private function getGood()
    {
        return [
            'user_contact_type' => (string)random_int(1111, 9999) . ' Contact ' . (string)random_int(111, 999),
        ];
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
            'user_contact_type' => 'Email',
        ];
        $dates = [
            'modified',
            'created',
        ];

        $this->validateInitialise($expected, $this->UserContactTypes, 2, $dates);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @throws \Exception
     */
    public function testValidationDefault()
    {
        $new = $this->UserContactTypes->newEntity($this->getGood());
        TestCase::assertInstanceOf(UserContactType::class, $this->UserContactTypes->save($new));

        $required = [
            'user_contact_type',
        ];
        $this->validateRequired($required, $this->UserContactTypes, [$this, 'getGood']);

        $notEmpties = [
            'user_contact_type',
        ];
        $this->validateNotEmpties($notEmpties, $this->UserContactTypes, [$this, 'getGood']);

        $maxLengths = [
            'user_contact_type' => 32,
        ];
        $this->validateMaxLengths($maxLengths, $this->UserContactTypes, [$this, 'getGood']);
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @throws \Exception
     */
    public function testBuildRules()
    {
        $this->validateUniqueRule(UserContactType::FIELD_USER_CONTACT_TYPE, $this->UserContactTypes, [$this, 'getGood']);
    }
}

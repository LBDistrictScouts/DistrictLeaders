<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PasswordStatesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\Utility\Security;

/**
 * App\Model\Table\PasswordStatesTable Test Case
 */
class PasswordStatesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PasswordStatesTable
     */
    public $PasswordStates;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PasswordStates',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PasswordStates') ? [] : ['className' => PasswordStatesTable::class];
        $this->PasswordStates = TableRegistry::getTableLocator()->get('PasswordStates', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PasswordStates);

        parent::tearDown();
    }

    /**
     * Get Good Set Function
     *
     * @return array
     *
     * @throws
     */
    private function getGood()
    {
        $good = [
            'password_state' => 'Status ' . random_int(111, 999) . ' ' . random_int(111, 999),
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
        $actual = $this->PasswordStates->get(1)->toArray();

        $expected = [
            'id' => 1,
            'password_state' => 'Lorem ipsum dolor sit amet',
            'active' => true,
            'expired' => false,
        ];
        TestCase::assertEquals($expected, $actual);

        $count = $this->PasswordStates->find('all')->count();
        TestCase::assertEquals(1, $count);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $good = $this->getGood();

        $new = $this->PasswordStates->newEntity($good);
        TestCase::assertInstanceOf('App\Model\Entity\PasswordState', $this->PasswordStates->save($new));

        $required = [
            'password_state',
            'active',
            'expired',
        ];

        foreach ($required as $require) {
            $reqArray = $this->getGood();
            unset($reqArray[$require]);
            $new = $this->PasswordStates->newEntity($reqArray);
            TestCase::assertFalse($this->PasswordStates->save($new));
        }

        $notRequired = [
        ];

        foreach ($notRequired as $notRequire) {
            $reqArray = $this->getGood();
            unset($reqArray[$notRequire]);
            $new = $this->PasswordStates->newEntity($reqArray);
            TestCase::assertInstanceOf('App\Model\Entity\PasswordState', $this->PasswordStates->save($new));
        }

        $empties = [
        ];

        foreach ($empties as $empty) {
            $reqArray = $this->getGood();
            $reqArray[$empty] = '';
            $new = $this->PasswordStates->newEntity($reqArray);
            TestCase::assertInstanceOf('App\Model\Entity\PasswordState', $this->PasswordStates->save($new));
        }

        $notEmpties = [
            'password_state',
            'active',
            'expired',
        ];

        foreach ($notEmpties as $notEmpty) {
            $reqArray = $this->getGood();
            $reqArray[$notEmpty] = '';
            $new = $this->PasswordStates->newEntity($reqArray);
            TestCase::assertFalse($this->PasswordStates->save($new));
        }

        $maxLengths = [
            'password_state' => 255,
        ];

        $string = hash('sha512', Security::randomBytes(64));
        $string .= $string;
        $string .= $string;

        foreach ($maxLengths as $maxField => $maxLength) {
            $reqArray = $this->getGood();
            $reqArray[$maxField] = substr($string, 1, $maxLength);
            $new = $this->PasswordStates->newEntity($reqArray);
            TestCase::assertInstanceOf('App\Model\Entity\PasswordState', $this->PasswordStates->save($new));

            $reqArray = $this->getGood();
            $reqArray[$maxField] = substr($string, 1, $maxLength + 1);
            $new = $this->PasswordStates->newEntity($reqArray);
            TestCase::assertFalse($this->PasswordStates->save($new));
        }
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $values = $this->getGood();

        $existing = $this->PasswordStates->get(1)->toArray();

        $values['password_state'] = 'My new Camp Role Type';
        $new = $this->PasswordStates->newEntity($values);
        TestCase::assertInstanceOf('App\Model\Entity\PasswordState', $this->PasswordStates->save($new));

        $values['password_state'] = $existing['password_state'];
        $new = $this->PasswordStates->newEntity($values);
        TestCase::assertFalse($this->PasswordStates->save($new));
    }
}

<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UserContactTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\Utility\Security;

/**
 * App\Model\Table\UserContactTypesTable Test Case
 */
class UserContactTypesTableTest extends TestCase
{
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
        $config = TableRegistry::getTableLocator()->exists('UserContactTypes') ? [] : ['className' => UserContactTypesTable::class];
        $this->UserContactTypes = TableRegistry::getTableLocator()->get('UserContactTypes', $config);
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
        $good = [
            'user_contact_type' => random_int(1111, 9999) . ' Contact ' . random_int(111, 999),
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
        $actual = $this->UserContactTypes->get(1)->toArray();

        $dates = [
            'modified',
            'created',
        ];

        foreach ($dates as $date) {
            $dateValue = $actual[$date];
            if (!is_null($dateValue)) {
                TestCase::assertInstanceOf('Cake\I18n\FrozenTime', $dateValue);
            }
            unset($actual[$date]);
        }

        $expected = [
            'id' => 1,
            'user_contact_type' => 'Email',
        ];
        TestCase::assertEquals($expected, $actual);

        $count = $this->UserContactTypes->find('all')->count();
        TestCase::assertEquals(1, $count);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @throws \Exception
     */
    public function testValidationDefault()
    {
        $good = $this->getGood();

        $new = $this->UserContactTypes->newEntity($good);
        TestCase::assertInstanceOf('App\Model\Entity\UserContactType', $this->UserContactTypes->save($new));

        $required = [
            'user_contact_type',
        ];

        foreach ($required as $require) {
            $reqArray = $good;
            unset($reqArray[$require]);
            $new = $this->UserContactTypes->newEntity($reqArray);
            TestCase::assertFalse($this->UserContactTypes->save($new));
        }

        $empties = [
        ];

        foreach ($empties as $empty) {
            $reqArray = $good;
            $reqArray[$empty] = '';
            $new = $this->UserContactTypes->newEntity($reqArray);
            TestCase::assertInstanceOf('App\Model\Entity\UserContactType', $this->UserContactTypes->save($new));
        }

        $notEmpties = [
            'user_contact_type',
        ];

        foreach ($notEmpties as $not_empty) {
            $reqArray = $good;
            $reqArray[$not_empty] = '';
            $new = $this->UserContactTypes->newEntity($reqArray);
            TestCase::assertFalse($this->UserContactTypes->save($new));
        }

        $maxLengths = [
            'user_contact_type' => 32,
        ];

        $string = hash('sha512', Security::randomBytes(64));
        $string .= $string;
        $string .= $string;

        foreach ($maxLengths as $maxField => $max_length) {
            $reqArray = $this->getGood();
            $reqArray[$maxField] = substr($string, 1, $max_length);
            $new = $this->UserContactTypes->newEntity($reqArray);
            TestCase::assertInstanceOf('App\Model\Entity\UserContactType', $this->UserContactTypes->save($new));

            $reqArray = $this->getGood();
            $reqArray[$maxField] = substr($string, 1, $max_length + 1);
            $new = $this->UserContactTypes->newEntity($reqArray);
            TestCase::assertFalse($this->UserContactTypes->save($new));
        }
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @throws \Exception
     */
    public function testBuildRules()
    {
        $values = $this->getGood();

        $existing = $this->UserContactTypes->get(1)->toArray();

        $values['user_contact_type'] = 'Phone';
        $new = $this->UserContactTypes->newEntity($values);
        TestCase::assertInstanceOf('App\Model\Entity\UserContactType', $this->UserContactTypes->save($new));

        $values['user_contact_type'] = $existing['user_contact_type'];
        $new = $this->UserContactTypes->newEntity($values);
        TestCase::assertFalse($this->UserContactTypes->save($new));
    }
}

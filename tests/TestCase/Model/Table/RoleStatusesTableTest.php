<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RoleStatusesTable;
use Cake\TestSuite\TestCase;
use Cake\Utility\Security;

/**
 * App\Model\Table\RoleStatusesTable Test Case
 */
class RoleStatusesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RoleStatusesTable
     */
    public $RoleStatuses;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.RoleStatuses',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('RoleStatuses') ? [] : ['className' => RoleStatusesTable::class];
        $this->RoleStatuses = $this->getTableLocator()->get('RoleStatuses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->RoleStatuses);

        parent::tearDown();
    }

    /**
     * Get Good Set Function
     *
     * @return array
     */
    private function getGood()
    {
        $good = [
            'role_status' => 'Lorem dolor sit amet',
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
        $actual = $this->RoleStatuses->get(1)->toArray();

        $expected = [
            'id' => 1,
            'role_status' => 'Lorem ipsum dolor sit amet',
        ];
        TestCase::assertEquals($expected, $actual);

        $count = $this->RoleStatuses->find('all')->count();
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

        $new = $this->RoleStatuses->newEntity($good);
        TestCase::assertInstanceOf('App\Model\Entity\RoleStatus', $this->RoleStatuses->save($new));

        $required = [
            'role_status',
        ];

        foreach ($required as $require) {
            $reqArray = $good;
            unset($reqArray[$require]);
            $new = $this->RoleStatuses->newEntity($reqArray);
            TestCase::assertFalse($this->RoleStatuses->save($new));
        }

        $empties = [
        ];

        foreach ($empties as $empty) {
            $reqArray = $good;
            $reqArray[$empty] = '';
            $new = $this->RoleStatuses->newEntity($reqArray);
            TestCase::assertInstanceOf('App\Model\Entity\RoleStatus', $this->RoleStatuses->save($new));
        }

        $notEmpties = [
            'role_status',
        ];

        foreach ($notEmpties as $not_empty) {
            $reqArray = $good;
            $reqArray[$not_empty] = '';
            $new = $this->RoleStatuses->newEntity($reqArray);
            TestCase::assertFalse($this->RoleStatuses->save($new));
        }

        $maxLengths = [
            'role_status' => 255,
        ];

        $string = hash('sha512', Security::randomBytes(64));
        $string .= $string;
        $string .= $string;

        foreach ($maxLengths as $maxField => $max_length) {
            $reqArray = $this->getGood();
            $reqArray[$maxField] = substr($string, 1, $max_length);
            $new = $this->RoleStatuses->newEntity($reqArray);
            TestCase::assertInstanceOf('App\Model\Entity\RoleStatus', $this->RoleStatuses->save($new));

            $reqArray = $this->getGood();
            $reqArray[$maxField] = substr($string, 1, $max_length + 1);
            $new = $this->RoleStatuses->newEntity($reqArray);
            TestCase::assertFalse($this->RoleStatuses->save($new));
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

        $existing = $this->RoleStatuses->get(1)->toArray();

        $values['role_status'] = 'My new Camp Role Type';
        $new = $this->RoleStatuses->newEntity($values);
        TestCase::assertInstanceOf('App\Model\Entity\RoleStatus', $this->RoleStatuses->save($new));

        $values['role_status'] = $existing['role_status'];
        $new = $this->RoleStatuses->newEntity($values);
        TestCase::assertFalse($this->RoleStatuses->save($new));
    }
}

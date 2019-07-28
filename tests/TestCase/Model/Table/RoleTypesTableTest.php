<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RoleTypesTable;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\Utility\Security;

/**
 * App\Model\Table\RoleTypesTable Test Case
 */
class RoleTypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RoleTypesTable
     */
    public $RoleTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.RoleTypes',
        'app.SectionTypes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('RoleTypes') ? [] : ['className' => RoleTypesTable::class];
        $this->RoleTypes = TableRegistry::getTableLocator()->get('RoleTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RoleTypes);

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
            'role_type' => 'My Role ' . random_int(1, 999) . random_int(1, 99),
            'role_abbreviation' => 'Go Go' . random_int(1, 999) . random_int(1, 99),
            'section_type_id' => 1,
            'level' => 1,
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
        $actual = $this->RoleTypes->get(1)->toArray();

        $expected = [
            'id' => 1,
            'role_type' => 'Lorem ipsum dolor sit amet',
            'role_abbreviation' => 'Lorem ipsum dolor sit amet',
            'section_type_id' => 1,
            'level' => 1,
        ];
        TestCase::assertEquals($expected, $actual);

        $count = $this->RoleTypes->find('all')->count();
        TestCase::assertEquals(7, $count);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $good = $this->getGood();

        $new = $this->RoleTypes->newEntity($good);
        TestCase::assertInstanceOf('App\Model\Entity\RoleType', $this->RoleTypes->save($new));

        $required = [
            'role_type',
            'level',
        ];

        foreach ($required as $require) {
            $reqArray = $this->getGood();
            unset($reqArray[$require]);
            $new = $this->RoleTypes->newEntity($reqArray);
            TestCase::assertFalse($this->RoleTypes->save($new));
        }

        $notRequired = [
            'role_abbreviation',
        ];

        foreach ($notRequired as $not_required) {
            $reqArray = $this->getGood();
            unset($reqArray[$not_required]);
            $new = $this->RoleTypes->newEntity($reqArray);
            TestCase::assertInstanceOf('App\Model\Entity\RoleType', $this->RoleTypes->save($new));
        }

        $empties = [
            'role_abbreviation',
        ];

        foreach ($empties as $empty) {
            $reqArray = $this->getGood();
            $reqArray[$empty] = '';
            $new = $this->RoleTypes->newEntity($reqArray);
            TestCase::assertInstanceOf('App\Model\Entity\RoleType', $this->RoleTypes->save($new));
        }

        $notEmpties = [
            'role_type',
            'level',
        ];

        foreach ($notEmpties as $not_empty) {
            $reqArray = $this->getGood();
            $reqArray[$not_empty] = '';
            $new = $this->RoleTypes->newEntity($reqArray);
            TestCase::assertFalse($this->RoleTypes->save($new));
        }

        $maxLengths = [
            'role_type' => 255,
            'role_abbreviation' => 32,
        ];

        $string = hash('sha512', Security::randomBytes(64));
        $string .= $string;
        $string .= $string;

        foreach ($maxLengths as $maxField => $max_length) {
            $reqArray = $this->getGood();
            $reqArray[$maxField] = substr($string, 1, $max_length);
            $new = $this->RoleTypes->newEntity($reqArray);
            TestCase::assertInstanceOf('App\Model\Entity\RoleType', $this->RoleTypes->save($new));

            $reqArray = $this->getGood();
            $reqArray[$maxField] = substr($string, 1, $max_length + 1);
            $new = $this->RoleTypes->newEntity($reqArray);
            TestCase::assertFalse($this->RoleTypes->save($new));
        }
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        // Role Type
        $values = $this->getGood();

        $existing = $this->RoleTypes->get(1)->toArray();

        $values['role_type'] = 'My new Role Type';
        $new = $this->RoleTypes->newEntity($values);
        TestCase::assertInstanceOf('App\Model\Entity\RoleType', $this->RoleTypes->save($new));

        $values['role_type'] = $existing['role_type'];
        $new = $this->RoleTypes->newEntity($values);
        TestCase::assertFalse($this->RoleTypes->save($new));

        // Abbreviation
        $values = $this->getGood();

        $existing = $this->RoleTypes->get(1)->toArray();

        $values['role_abbreviation'] = 'My new Role Abbr';
        $new = $this->RoleTypes->newEntity($values);
        TestCase::assertInstanceOf('App\Model\Entity\RoleType', $this->RoleTypes->save($new));

        $values['role_abbreviation'] = $existing['role_abbreviation'];
        $new = $this->RoleTypes->newEntity($values);
        TestCase::assertFalse($this->RoleTypes->save($new));

        // Users
        $values = $this->getGood();
        $users = $this->RoleTypes->SectionTypes->find('list')->toArray();

        $user = max(array_keys($users));

        $values['section_type_id'] = $user;
        $new = $this->RoleTypes->newEntity($values);
        TestCase::assertInstanceOf('App\Model\Entity\RoleType', $this->RoleTypes->save($new));

        $values['section_type_id'] = $user + 1;
        $new = $this->RoleTypes->newEntity($values);
        TestCase::assertFalse($this->RoleTypes->save($new));
    }
}

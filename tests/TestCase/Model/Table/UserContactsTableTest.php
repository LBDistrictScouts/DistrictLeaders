<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UserContactsTable;
use Cake\I18n\FrozenTime;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\Utility\Security;

/**
 * App\Model\Table\UserContactsTable Test Case
 */
class UserContactsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UserContactsTable
     */
    public $UserContacts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.UserContacts',
        'app.UserContactTypes',
        'app.Users',
        'app.RoleTypes',
        'app.RoleStatuses',
        'app.Sections',
        'app.SectionTypes',
        'app.ScoutGroups',
        'app.Audits',
        'app.Roles',
        'app.Capabilities',
        'app.CapabilitiesRoleTypes',
        'app.TokenizeTokens',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('UserContacts') ? [] : ['className' => UserContactsTable::class];
        $this->UserContacts = TableRegistry::getTableLocator()->get('UserContacts', $config);

        $now = new FrozenTime('2018-12-26 23:22:30');
        FrozenTime::setTestNow($now);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserContacts);

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
            'user_id' => 1,
            'user_contact_type_id' => 1,
            'contact_field' => random_int(111, 999) . 'jacob.llama' . random_int(111, 999) . '@fishing.com',
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
        $actual = $this->UserContacts->get(1)->toArray();

        $dates = [
            'modified',
            'created',
            'deleted',
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
            'contact_field' => 'james@peach.com',
            'user_id' => 1,
            'user_contact_type_id' => 1,
            'verified' => 1,
        ];
        TestCase::assertEquals($expected, $actual);

        $count = $this->UserContacts->find('all')->count();
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

        $new = $this->UserContacts->newEntity($good);
        TestCase::assertInstanceOf('App\Model\Entity\UserContact', $this->UserContacts->save($new));

        $required = [
            'contact_field',
            'user_id',
            'user_contact_type_id',
        ];

        foreach ($required as $require) {
            $reqArray = $this->getGood();
            unset($reqArray[$require]);
            $new = $this->UserContacts->newEntity($reqArray);
            TestCase::assertFalse($this->UserContacts->save($new));
        }

        $notEmpties = [
            'contact_field',
            'user_id',
            'user_contact_type_id',
        ];

        foreach ($notEmpties as $not_empty) {
            $reqArray = $this->getGood();
            $reqArray[$not_empty] = '';
            $new = $this->UserContacts->newEntity($reqArray);
            TestCase::assertFalse($this->UserContacts->save($new));
        }

        $maxLengths = [
            'contact_field' => '64',
        ];

        $string = hash('sha512', Security::randomBytes(64));
        $string .= $string;
        $string .= $string;

        foreach ($maxLengths as $maxField => $max_length) {
            $reqArray = $this->getGood();
            $reqArray[$maxField] = substr($string, 1, $max_length);
            $new = $this->UserContacts->newEntity($reqArray);
            TestCase::assertInstanceOf('App\Model\Entity\UserContact', $this->UserContacts->save($new));

            $reqArray = $this->getGood();
            $reqArray[$maxField] = substr($string, 1, $max_length + 1);
            $new = $this->UserContacts->newEntity($reqArray);
            TestCase::assertFalse($this->UserContacts->save($new));
        }
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        // Is Unique
        $uniques = [
            'contact_field' => 'james.llama@giant.peach',
        ];

        foreach ($uniques as $unqueField => $uniqueValue) {
            $values = $this->getGood();

            $existing = $this->UserContacts->get(1)->toArray();

            $values[$unqueField] = $uniqueValue;
            $new = $this->UserContacts->newEntity($values);
            TestCase::assertInstanceOf('App\Model\Entity\UserContact', $this->UserContacts->save($new));

            $values = $this->getGood();

            $values[$unqueField] = $existing[$unqueField];
            $new = $this->UserContacts->newEntity($values);
            TestCase::assertFalse($this->UserContacts->save($new));
        }

        // User Contact Type Exists
        $values = $this->getGood();

        $types = $this->UserContacts->UserContactTypes->find('list')->toArray();

        $type = max(array_keys($types));

        $values['user_contact_type_id'] = $type;
        $new = $this->UserContacts->newEntity($values);
        TestCase::assertInstanceOf('App\Model\Entity\UserContact', $this->UserContacts->save($new));

        $values['user_contact_type_id'] = $type + 1;
        $new = $this->UserContacts->newEntity($values);
        TestCase::assertFalse($this->UserContacts->save($new));

        // User Exists
        $values = $this->getGood();

        $types = $this->UserContacts->Users->find('list')->toArray();

        $type = max(array_keys($types));

        $values['user_id'] = $type;
        $new = $this->UserContacts->newEntity($values);
        TestCase::assertInstanceOf('App\Model\Entity\UserContact', $this->UserContacts->save($new));

        $values['user_id'] = $type + 1;
        $new = $this->UserContacts->newEntity($values);
        TestCase::assertFalse($this->UserContacts->save($new));
    }
}

<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ScoutGroupsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\Utility\Security;

/**
 * App\Model\Table\ScoutGroupsTable Test Case
 */
class ScoutGroupsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ScoutGroupsTable
     */
    public $ScoutGroups;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ScoutGroups',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ScoutGroups') ? [] : ['className' => ScoutGroupsTable::class];
        $this->ScoutGroups = TableRegistry::getTableLocator()->get('ScoutGroups', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ScoutGroups);

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
        $number = random_int(1, 256) * random_int(1, 256);
        $good = [
            'scout_group' => $number . 'th Llamaworld Sea Scouts',
            'group_alias' => $number . 'th Llamaworld',
            'number_stripped' => $number,
            'charity_number' => 123456,
            'group_domain' => $number . 'thllamaworld.com',
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
        $actual = $this->ScoutGroups->get(1)->toArray();

        $dates = [
            'modified',
            'created',
            'deleted',
        ];

        foreach ($dates as $date) {
            $dateValue = $actual[$date];
            if (!is_null($dateValue)) {
                $this->assertInstanceOf('Cake\I18n\FrozenTime', $dateValue);
            }
            unset($actual[$date]);
        }

        $expected = [
            'id' => 1,
            'scout_group' => 'Lorem ipsum dolor sit amet',
            'group_alias' => 'Lorem ipsum dolor sit amet',
            'number_stripped' => 1,
            'charity_number' => 1,
            'group_domain' => 'Lorem ipsum dolor sit amet',
        ];
        $this->assertEquals($expected, $actual);

        $count = $this->ScoutGroups->find('all')->count();
        $this->assertEquals(1, $count);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $good = $this->getGood();

        $new = $this->ScoutGroups->newEntity($good);
        $this->assertInstanceOf('App\Model\Entity\ScoutGroup', $this->ScoutGroups->save($new));

        $required = [
            'scout_group',
        ];

        foreach ($required as $require) {
            $reqArray = $this->getGood();
            unset($reqArray[$require]);
            $new = $this->ScoutGroups->newEntity($reqArray);
            $this->assertFalse($this->ScoutGroups->save($new));
        }

        $empties = [
            'group_alias',
            'number_stripped',
            'charity_number',
            'group_domain',
        ];

        foreach ($empties as $empty) {
            $reqArray = $this->getGood();
            $reqArray[$empty] = '';
            $new = $this->ScoutGroups->newEntity($reqArray);
            $this->assertInstanceOf('App\Model\Entity\ScoutGroup', $this->ScoutGroups->save($new));
        }

        $notEmpties = [
            'scout_group',
        ];

        foreach ($notEmpties as $not_empty) {
            $reqArray = $this->getGood();
            $reqArray[$not_empty] = '';
            $new = $this->ScoutGroups->newEntity($reqArray);
            $this->assertFalse($this->ScoutGroups->save($new));
        }

        $maxLengths = [
            'group_domain' => 247,
            'group_alias' => 30,
            'scout_group' => 255,
        ];

        $string = hash('sha512', Security::randomBytes(64));
        $string .= $string;
        $string .= $string;

        foreach ($maxLengths as $maxField => $max_length) {
            $reqArray = $this->getGood();
            $reqArray[$maxField] = substr($string, 1, $max_length);
            $new = $this->ScoutGroups->newEntity($reqArray);
            $this->assertInstanceOf('App\Model\Entity\ScoutGroup', $this->ScoutGroups->save($new));

            $reqArray = $this->getGood();
            $reqArray[$maxField] = substr($string, 1, $max_length + 1);
            $new = $this->ScoutGroups->newEntity($reqArray);
            $this->assertFalse($this->ScoutGroups->save($new));
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

        $existing = $this->ScoutGroups->get(1)->toArray();

        $values['scout_group'] = 'My new Camp Role Type';
        $new = $this->ScoutGroups->newEntity($values);
        $this->assertInstanceOf('App\Model\Entity\ScoutGroup', $this->ScoutGroups->save($new));

        $values['scout_group'] = $existing['scout_group'];
        $new = $this->ScoutGroups->newEntity($values);
        $this->assertFalse($this->ScoutGroups->save($new));
    }

    /**
     * Test setter method
     *
     * @return void
     */
    public function testSetters()
    {
        // WWW. Removal
        $values = $this->getGood();

        $values['group_domain'] = 'www.4thletchworth.com';
        $expected = 'https://4thletchworth.com';

        $new = $this->ScoutGroups->newEntity($values);
        $this->assertInstanceOf('App\Model\Entity\ScoutGroup', $this->ScoutGroups->save($new));

        $actual = $this->ScoutGroups->get($new->id)->toArray();
        $this->assertEquals($expected, $actual['group_domain']);

        // Blank Domain
        $values = $this->getGood();

        $values['group_domain'] = '5thletchworth.com';
        $expected = 'https://5thletchworth.com';

        $new = $this->ScoutGroups->newEntity($values);
        $this->assertInstanceOf('App\Model\Entity\ScoutGroup', $this->ScoutGroups->save($new));

        $actual = $this->ScoutGroups->get($new->id)->toArray();
        $this->assertEquals($expected, $actual['group_domain']);

        // HTTP Domain
        $values = $this->getGood();

        $values['group_domain'] = 'http://6thletchworth.com';
        $expected = 'http://6thletchworth.com';

        $new = $this->ScoutGroups->newEntity($values);
        $this->assertInstanceOf('App\Model\Entity\ScoutGroup', $this->ScoutGroups->save($new));

        $actual = $this->ScoutGroups->get($new->id)->toArray();
        $this->assertEquals($expected, $actual['group_domain']);
    }
}

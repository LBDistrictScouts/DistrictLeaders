<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\ScoutGroup;
use App\Model\Table\ScoutGroupsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\Utility\Security;

/**
 * App\Model\Table\ScoutGroupsTable Test Case
 */
class ScoutGroupsTableTest extends TestCase
{
    use ModelTestTrait;

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
        $dates = [
            ScoutGroup::FIELD_MODIFIED,
            ScoutGroup::FIELD_CREATED,
            ScoutGroup::FIELD_DELETED,
        ];

        $expected = [
            ScoutGroup::FIELD_ID => 1,
            ScoutGroup::FIELD_SCOUT_GROUP => '4th Goat Town',
            ScoutGroup::FIELD_GROUP_ALIAS => '4th Goat',
            ScoutGroup::FIELD_NUMBER_STRIPPED => 4,
            ScoutGroup::FIELD_CHARITY_NUMBER => 134,
            ScoutGroup::FIELD_GROUP_DOMAIN => '4thgoat.org.uk',
            ScoutGroup::FIELD_CLEAN_DOMAIN => '4thgoat.org.uk'
        ];

        $this->validateInitialise($expected, $this->ScoutGroups, 2, $dates);
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
        TestCase::assertInstanceOf('App\Model\Entity\ScoutGroup', $this->ScoutGroups->save($new));

        $required = [
            'scout_group',
        ];

        foreach ($required as $require) {
            $reqArray = $this->getGood();
            unset($reqArray[$require]);
            $new = $this->ScoutGroups->newEntity($reqArray);
            TestCase::assertFalse($this->ScoutGroups->save($new));
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
            TestCase::assertInstanceOf('App\Model\Entity\ScoutGroup', $this->ScoutGroups->save($new));
        }

        $notEmpties = [
            'scout_group',
        ];

        foreach ($notEmpties as $not_empty) {
            $reqArray = $this->getGood();
            $reqArray[$not_empty] = '';
            $new = $this->ScoutGroups->newEntity($reqArray);
            TestCase::assertFalse($this->ScoutGroups->save($new));
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
            TestCase::assertInstanceOf('App\Model\Entity\ScoutGroup', $this->ScoutGroups->save($new));

            $reqArray = $this->getGood();
            $reqArray[$maxField] = substr($string, 1, $max_length + 1);
            $new = $this->ScoutGroups->newEntity($reqArray);
            TestCase::assertFalse($this->ScoutGroups->save($new));
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
        TestCase::assertInstanceOf('App\Model\Entity\ScoutGroup', $this->ScoutGroups->save($new));

        $values['scout_group'] = $existing['scout_group'];
        $new = $this->ScoutGroups->newEntity($values);
        TestCase::assertFalse($this->ScoutGroups->save($new));
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
        TestCase::assertInstanceOf('App\Model\Entity\ScoutGroup', $this->ScoutGroups->save($new));

        $actual = $this->ScoutGroups->get($new->id)->toArray();
        TestCase::assertEquals($expected, $actual['group_domain']);

        // Blank Domain
        $values = $this->getGood();

        $values['group_domain'] = '5thletchworth.com';
        $expected = 'https://5thletchworth.com';

        $new = $this->ScoutGroups->newEntity($values);
        TestCase::assertInstanceOf('App\Model\Entity\ScoutGroup', $this->ScoutGroups->save($new));

        $actual = $this->ScoutGroups->get($new->id)->toArray();
        TestCase::assertEquals($expected, $actual['group_domain']);

        // HTTP Domain
        $values = $this->getGood();

        $values['group_domain'] = 'http://6thletchworth.com';
        $expected = 'http://6thletchworth.com';

        $new = $this->ScoutGroups->newEntity($values);
        TestCase::assertInstanceOf('App\Model\Entity\ScoutGroup', $this->ScoutGroups->save($new));

        $actual = $this->ScoutGroups->get($new->id)->toArray();
        TestCase::assertEquals($expected, $actual['group_domain']);
    }

    /**
     * Test Get Domains method
     *
     * @return void
     */
    public function testGetDomains()
    {
        $expected = [
            '4thgoat.org.uk',
            '8thfish.co.uk'
        ];
        $actual = $this->ScoutGroups->getDomains();
        TestCase::assertSame($expected, $actual);
    }

    /**
     * @return array
     */
    public function providerDomainVerifyData()
    {
        return [
            ['4thgoat.org.uk', true],
            ['8thfish.co.uk', true],
            ['buttons.com', false],
            ['bad.goat', false],
        ];
    }

    /**
     * Test Domain Verification method
     *
     * @param string $emailString String to be encoded
     * @param bool $expected Expected Result
     *
     * @return void
     *
     * @dataProvider providerDomainVerifyData
     */
    public function testDomainVerify($emailString, $expected)
    {
        $email = 'jacob@' . $emailString;
        TestCase::assertEquals($expected, $this->ScoutGroups->domainVerify($email));
    }
}

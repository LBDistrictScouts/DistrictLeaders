<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CapabilitiesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\Utility\Security;

/**
 * App\Model\Table\CapabilitiesTable Test Case
 */
class CapabilitiesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CapabilitiesTable
     */
    public $Capabilities;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Capabilities',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Capabilities') ? [] : ['className' => CapabilitiesTable::class];
        $this->Capabilities = TableRegistry::getTableLocator()->get('Capabilities', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Capabilities);

        parent::tearDown();
    }

    /**
     * Get Good Set Function
     *
     * @return array
     *
     * @throws
     */
    public function getGood()
    {
        $good = [
            'capability_code' => 'NEW' . random_int(0, 999),
            'capability' => 'Llama Permissions' . random_int(0, 999),
            'min_level' => random_int(0, 5),
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
        $actual = $this->Capabilities->get(1)->toArray();

        $expected = [
            'id' => 1,
            'capability_code' => 'ALL',
            'capability' => 'SuperUser Permissions',
            'min_level' => 5,
        ];
        TestCase::assertEquals($expected, $actual);

        $count = $this->Capabilities->find('all')->count();
        TestCase::assertEquals(6, $count);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $good = $this->getGood();

        $new = $this->Capabilities->newEntity($good);
        TestCase::assertInstanceOf('App\Model\Entity\Capability', $this->Capabilities->save($new));

        $required = [
            'min_level',
            'capability_code',
            'capability',
        ];

        foreach ($required as $require) {
            $reqArray = $good;
            unset($reqArray[$require]);
            $new = $this->Capabilities->newEntity($reqArray);
            TestCase::assertFalse($this->Capabilities->save($new));
        }

        $notEmpties = [
            'min_level',
            'capability_code',
            'capability',
        ];

        foreach ($notEmpties as $not_empty) {
            $reqArray = $good;
            $reqArray[$not_empty] = '';
            $new = $this->Capabilities->newEntity($reqArray);
            TestCase::assertFalse($this->Capabilities->save($new));
        }

        $maxLengths = [
            'capability_code' => 10,
            'capability' => 255,
        ];

        $string = hash('sha512', Security::randomBytes(256));
        $string .= $string;
        $string .= $string;

        foreach ($maxLengths as $maxField => $max_length) {
            $reqArray = $this->getGood();
            $reqArray[$maxField] = substr($string, 1, $max_length);
            $new = $this->Capabilities->newEntity($reqArray);
            TestCase::assertInstanceOf('App\Model\Entity\Capability', $this->Capabilities->save($new));

            $reqArray = $this->getGood();
            $reqArray[$maxField] = substr($string, 1, $max_length + 1);
            $new = $this->Capabilities->newEntity($reqArray);
            TestCase::assertFalse($this->Capabilities->save($new));
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
            'capability_code' => 'FACE',
            'capability' => 'I LIKE CHEESE',
        ];

        foreach ($uniques as $unqueField => $uniqueValue) {
            $values = $this->getGood();

            $existing = $this->Capabilities->get(1)->toArray();

            $values[$unqueField] = $uniqueValue;
            $new = $this->Capabilities->newEntity($values);
            TestCase::assertInstanceOf('App\Model\Entity\Capability', $this->Capabilities->save($new));

            $values = $this->getGood();

            $values[$unqueField] = $existing[$unqueField];
            $new = $this->Capabilities->newEntity($values);
            TestCase::assertFalse($this->Capabilities->save($new));
        }
    }

    /**
     * Test installBaseCapabilities method
     *
     * @return void
     */
    public function testInstallBaseCapabilities()
    {
        $before = $this->Capabilities->find('all')->count();

        $installed = $this->Capabilities->installBaseCapabilities();

//        TestCase::assertNotEquals($before, $installed);
        TestCase::assertNotEquals(0, $installed);

        $new = $before + $installed;
        $after = $this->Capabilities->find('all')->count();

        TestCase::assertEquals($new, $after);
    }
}

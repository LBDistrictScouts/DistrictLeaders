<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CampTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\Utility\Security;

/**
 * App\Model\Table\CampTypesTable Test Case
 */
class CampTypesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CampTypesTable
     */
    public $CampTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CampTypes',
        'app.Camps',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CampTypes') ? [] : ['className' => CampTypesTable::class];
        $this->CampTypes = TableRegistry::getTableLocator()->get('CampTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->CampTypes);

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
            'camp_type' => 'Lorem ipsum amet',
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
        $actual = $this->CampTypes->get(1)->toArray();

        $expected = [
            'id' => 1,
            'camp_type' => 'Lorem ipsum sit amet',
        ];
        TestCase::assertEquals($expected, $actual);

        $count = $this->CampTypes->find('all')->count();
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

        $new = $this->CampTypes->newEntity($good);
        TestCase::assertInstanceOf('App\Model\Entity\CampType', $this->CampTypes->save($new));

        $required = [
            'camp_type',
        ];

        foreach ($required as $require) {
            $reqArray = $good;
            unset($reqArray[$require]);
            $new = $this->CampTypes->newEntity($reqArray);
            TestCase::assertFalse($this->CampTypes->save($new));
        }

        $empties = [
        ];

        foreach ($empties as $empty) {
            $reqArray = $good;
            $reqArray[$empty] = '';
            $new = $this->CampTypes->newEntity($reqArray);
            TestCase::assertInstanceOf('App\Model\Entity\CampType', $this->CampTypes->save($new));
        }

        $notEmpties = [
            'camp_type',
        ];

        foreach ($notEmpties as $not_empty) {
            $reqArray = $good;
            $reqArray[$not_empty] = '';
            $new = $this->CampTypes->newEntity($reqArray);
            TestCase::assertFalse($this->CampTypes->save($new));
        }

        $maxLengths = [
            'camp_type' => 30,
        ];

        $string = hash('sha512', Security::randomBytes(64));
        $string .= $string;
        $string .= $string;

        foreach ($maxLengths as $maxField => $max_length) {
            $reqArray = $this->getGood();
            $reqArray[$maxField] = substr($string, 1, $max_length);
            $new = $this->CampTypes->newEntity($reqArray);
            TestCase::assertInstanceOf('App\Model\Entity\CampType', $this->CampTypes->save($new));

            $reqArray = $this->getGood();
            $reqArray[$maxField] = substr($string, 1, $max_length + 1);
            $new = $this->CampTypes->newEntity($reqArray);
            TestCase::assertFalse($this->CampTypes->save($new));
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

        $existing = $this->CampTypes->get(1)->toArray();

        $values['camp_type'] = 'My new Camp Role Type';
        $new = $this->CampTypes->newEntity($values);
        TestCase::assertInstanceOf('App\Model\Entity\CampType', $this->CampTypes->save($new));

        $values['camp_type'] = $existing['camp_type'];
        $new = $this->CampTypes->newEntity($values);
        TestCase::assertFalse($this->CampTypes->save($new));
    }
}

<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CampsTable;
use Cake\I18n\Time;
use Cake\TestSuite\TestCase;
use Cake\Utility\Security;

/**
 * App\Model\Table\CampsTable Test Case
 */
class CampsTableTest extends TestCase
{
    use ModelTestTrait;

    /**
     * Test subject
     *
     * @var CampsTable
     */
    public CampsTable $Camps;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Camps') ? [] : ['className' => CampsTable::class];
        $this->Camps = $this->getTableLocator()->get('Camps', $config);

        $now = new Time('2018-12-26 23:22:30');
        Time::setTestNow($now);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Camps);

        parent::tearDown();
    }

    /**
     * Get Good Set Function
     *
     * @return array
     * @throws
     */
    private function getGood()
    {
        $date = Time::getTestNow();
        $good = [
            'camp_name' => 'Camp ' . random_int(0, 999) . random_int(0, 99),
            'camp_type_id' => 1,
            'camp_start' => $date,
            'camp_end' => $date,
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
        $actual = $this->Camps->get(1)->toArray();

        $dates = [
            'modified',
            'created',
            'deleted',
            'camp_start',
            'camp_end',
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
            'camp_name' => 'Lorem ipsum dolor sit amet',
            'camp_type_id' => 1,
        ];
        TestCase::assertEquals($expected, $actual);

        $count = $this->Camps->find('all')->count();
        TestCase::assertEquals(2, $count);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $good = $this->getGood();

        $new = $this->Camps->newEntity($good);
        TestCase::assertInstanceOf('App\Model\Entity\Camp', $this->Camps->save($new));

        $required = [
            'camp_name',
            'camp_start',
            'camp_end',
        ];

        foreach ($required as $require) {
            $reqArray = $this->getGood();
            unset($reqArray[$require]);
            $new = $this->Camps->newEntity($reqArray);
            TestCase::assertFalse($this->Camps->save($new));
        }

        $notEmpties = [
            'camp_name',
            'camp_start',
            'camp_end',
        ];

        foreach ($notEmpties as $not_empty) {
            $reqArray = $this->getGood();
            $reqArray[$not_empty] = '';
            $new = $this->Camps->newEntity($reqArray);
            TestCase::assertFalse($this->Camps->save($new));
        }

        $maxLengths = [
            'camp_name' => 255,
        ];

        $string = hash('sha512', Security::randomBytes(64));
        $string .= $string;
        $string .= $string;

        foreach ($maxLengths as $maxField => $max_length) {
            $reqArray = $this->getGood();
            $reqArray[$maxField] = substr($string, 1, $max_length);
            $new = $this->Camps->newEntity($reqArray);
            TestCase::assertInstanceOf('App\Model\Entity\Camp', $this->Camps->save($new));

            $reqArray = $this->getGood();
            $reqArray[$maxField] = substr($string, 1, $max_length + 1);
            $new = $this->Camps->newEntity($reqArray);
            TestCase::assertFalse($this->Camps->save($new));
        }
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        // Camp Type Exists
        $values = $this->getGood();

        $types = $this->Camps->CampTypes->find('list')->toArray();

        $type = max(array_keys($types));

        $values['camp_type_id'] = $type;
        $new = $this->Camps->newEntity($values);
        TestCase::assertInstanceOf('App\Model\Entity\Camp', $this->Camps->save($new));

        $values['camp_type_id'] = $type + 1;
        $new = $this->Camps->newEntity($values);
        TestCase::assertFalse($this->Camps->save($new));
    }
}

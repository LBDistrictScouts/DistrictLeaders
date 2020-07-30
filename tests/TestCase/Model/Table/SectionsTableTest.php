<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SectionsTable;
use Cake\TestSuite\TestCase;
use Cake\Utility\Security;

/**
 * App\Model\Table\SectionsTable Test Case
 */
class SectionsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SectionsTable
     */
    public $Sections;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Sections',
        'app.SectionTypes',
        'app.ScoutGroups',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Sections') ? [] : ['className' => SectionsTable::class];
        $this->Sections = $this->getTableLocator()->get('Sections', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Sections);

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
        $good = [
            'section' => 'Happy Group' . random_int(2, 99) . random_int(0, 930),
            'section_type_id' => 1,
            'scout_group_id' => 1,
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
        $actual = $this->Sections->get(1)->toArray();

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
            'section' => 'Lorem ipsum dolor sit amet',
            'section_type_id' => 1,
            'scout_group_id' => 1,
            'public' => true,
            'meeting_day' => 3,
            'meeting_start_time' => '18:00',
            'meeting_end_time' => '19:00',
            'uuid' => 'b2da6b3a-e406-4069-bd24-12c28cb816d1',
            'meeting_weekday' => 'Wednesday',
        ];
        TestCase::assertEquals($expected, $actual);

        $count = $this->Sections->find('all')->count();
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

        $new = $this->Sections->newEntity($good);
        TestCase::assertInstanceOf('App\Model\Entity\Section', $this->Sections->save($new));

        $required = [
            'section',
        ];

        foreach ($required as $require) {
            $reqArray = $this->getGood();
            unset($reqArray[$require]);
            $new = $this->Sections->newEntity($reqArray);
            TestCase::assertFalse($this->Sections->save($new));
        }

        $notEmpties = [
            'section',
        ];

        foreach ($notEmpties as $not_empty) {
            $reqArray = $this->getGood();
            $reqArray[$not_empty] = '';
            $new = $this->Sections->newEntity($reqArray);
            TestCase::assertFalse($this->Sections->save($new));
        }

        $maxLengths = [
            'section' => 255,
        ];

        $string = hash('sha512', Security::randomBytes(64));
        $string .= $string;
        $string .= $string;

        foreach ($maxLengths as $maxField => $max_length) {
            $reqArray = $this->getGood();
            $reqArray[$maxField] = substr($string, 1, $max_length);
            $new = $this->Sections->newEntity($reqArray);
            TestCase::assertInstanceOf('App\Model\Entity\Section', $this->Sections->save($new));

            $reqArray = $this->getGood();
            $reqArray[$maxField] = substr($string, 1, $max_length + 1);
            $new = $this->Sections->newEntity($reqArray);
            TestCase::assertFalse($this->Sections->save($new));
        }
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        // Admin Group Exists
        $values = $this->getGood();

        $groups = $this->Sections->ScoutGroups->find('list')->toArray();

        $group = max(array_keys($groups));

        $values['scout_group_id'] = $group;
        $new = $this->Sections->newEntity($values);
        TestCase::assertInstanceOf('App\Model\Entity\Section', $this->Sections->save($new));

        $values['scout_group_id'] = $group + 1;
        $new = $this->Sections->newEntity($values);
        TestCase::assertFalse($this->Sections->save($new));

        // Is Unique
        $uniques = [
            'section' => 'My New Section',
        ];

        foreach ($uniques as $unqueField => $uniqueValue) {
            $values = $this->getGood();

            $existing = $this->Sections->get(1)->toArray();

            $values[$unqueField] = $uniqueValue;
            $new = $this->Sections->newEntity($values);
            TestCase::assertInstanceOf('App\Model\Entity\Section', $this->Sections->save($new));

            $values = $this->getGood();

            $values[$unqueField] = $existing[$unqueField];
            $new = $this->Sections->newEntity($values);
            TestCase::assertFalse($this->Sections->save($new));
        }
    }
}

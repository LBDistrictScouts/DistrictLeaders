<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CampRoleTypesTable;
use Cake\TestSuite\TestCase;
use Cake\Utility\Security;

/**
 * App\Model\Table\CampRoleTypesTable Test Case
 */
class CampRoleTypesTableTest extends TestCase
{
    use ModelTestTrait;

    /**
     * Test subject
     *
     * @var CampRoleTypesTable
     */
    public CampRoleTypesTable $CampRoleTypes;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CampRoleTypes') ? [] : ['className' => CampRoleTypesTable::class];
        $this->CampRoleTypes = $this->getTableLocator()->get('CampRoleTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->CampRoleTypes);

        parent::tearDown();
    }

    /**
     * Get Good Set Function
     *
     * @return array
     */
    private function getGood(): array
    {
        $good = [
            'camp_role_type' => 'Lorem ipsum sit amet',
        ];

        return $good;
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize(): void
    {
        $actual = $this->CampRoleTypes->get(1)->toArray();

        $dates = [
            'modified',
            'created',
        ];

        foreach ($dates as $date) {
            $dateValue = $actual[$date];
            TestCase::assertInstanceOf('Cake\I18n\FrozenTime', $dateValue);
            unset($actual[$date]);
        }

        $expected = [
            'id' => 1,
            'camp_role_type' => 'Lorem ipsum dolor sit amet',
        ];
        TestCase::assertEquals($expected, $actual);

        $count = $this->CampRoleTypes->find('all')->count();
        TestCase::assertEquals(1, $count);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $good = $this->getGood();

        $new = $this->CampRoleTypes->newEntity($good);
        TestCase::assertInstanceOf('App\Model\Entity\CampRoleType', $this->CampRoleTypes->save($new));

        $required = [
            'camp_role_type',
        ];

        foreach ($required as $require) {
            $reqArray = $good;
            unset($reqArray[$require]);
            $new = $this->CampRoleTypes->newEntity($reqArray);
            TestCase::assertFalse($this->CampRoleTypes->save($new));
        }

        $empties = [
        ];

        foreach ($empties as $empty) {
            $reqArray = $good;
            $reqArray[$empty] = '';
            $new = $this->CampRoleTypes->newEntity($reqArray);
            TestCase::assertInstanceOf('App\Model\Entity\CampRoleType', $this->CampRoleTypes->save($new));
        }

        $notEmpties = [
            'camp_role_type',
        ];

        foreach ($notEmpties as $not_empty) {
            $reqArray = $good;
            $reqArray[$not_empty] = '';
            $new = $this->CampRoleTypes->newEntity($reqArray);
            TestCase::assertFalse($this->CampRoleTypes->save($new));
        }

        $maxLengths = [
            'camp_role_type' => 30,
        ];

        $string = hash('sha256', Security::randomBytes(64));

        foreach ($maxLengths as $maxField => $max_length) {
            $reqArray = $good;
            $reqArray[$maxField] = substr($string, 1, $max_length);
            $new = $this->CampRoleTypes->newEntity($reqArray);
            TestCase::assertInstanceOf('App\Model\Entity\CampRoleType', $this->CampRoleTypes->save($new));

            $reqArray = $good;
            $reqArray[$maxField] = substr($string, 1, $max_length + 1);
            $new = $this->CampRoleTypes->newEntity($reqArray);
            TestCase::assertFalse($this->CampRoleTypes->save($new));
        }
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $values = $this->getGood();

        $existing = $this->CampRoleTypes->get(1)->toArray();

        $values['camp_role_type'] = 'My new Camp Role Type';
        $new = $this->CampRoleTypes->newEntity($values);
        TestCase::assertInstanceOf('App\Model\Entity\CampRoleType', $this->CampRoleTypes->save($new));

        $values['camp_role_type'] = $existing['camp_role_type'];
        $new = $this->CampRoleTypes->newEntity($values);
        TestCase::assertFalse($this->CampRoleTypes->save($new));
    }
}

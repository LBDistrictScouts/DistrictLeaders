<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CampRolesTable;
use Cake\I18n\Time;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CampRolesTable Test Case
 */
class CampRolesTableTest extends TestCase
{
    use ModelTestTrait;

    /**
     * Test subject
     *
     * @var CampRolesTable
     */
    public CampRolesTable $CampRoles;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CampRoles') ? [] : ['className' => CampRolesTable::class];
        $this->CampRoles = $this->getTableLocator()->get('CampRoles', $config);

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
        unset($this->CampRoles);

        parent::tearDown();
    }

    /**
     * Get Good Set Function
     *
     * @return array
     */
    private function getGood()
    {
        $date = Time::getTestNow();
        $good = [
            'created' => $date,
            'modified' => $date,
            'camp_id' => 1,
            'user_id' => 1,
            'camp_role_type_id' => 1,
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
        $actual = $this->CampRoles->get(1)->toArray();

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
            'camp_id' => 1,
            'user_id' => 1,
            'camp_role_type_id' => 1,
        ];
        TestCase::assertEquals($expected, $actual);

        $count = $this->CampRoles->find('all')->count();
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

        $new = $this->CampRoles->newEntity($good);
        TestCase::assertInstanceOf('App\Model\Entity\CampRole', $this->CampRoles->save($new));
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        // Users
        $values = $this->getGood();
        $users = $this->CampRoles->Users->find('list')->toArray();

        $user = max(array_keys($users));

        $values['user_id'] = $user;
        $new = $this->CampRoles->newEntity($values);
        TestCase::assertInstanceOf('App\Model\Entity\CampRole', $this->CampRoles->save($new));

        $values['user_id'] = $user + 1;
        $new = $this->CampRoles->newEntity($values);
        TestCase::assertFalse($this->CampRoles->save($new));

        // Camps
        $values = $this->getGood();
        $camps = $this->CampRoles->Camps->find('list')->toArray();

        $camp = max(array_keys($camps));

        $values['camp_id'] = $camp;
        $new = $this->CampRoles->newEntity($values);
        TestCase::assertInstanceOf('App\Model\Entity\CampRole', $this->CampRoles->save($new));

        $values['camp_id'] = $camp + 1;
        $new = $this->CampRoles->newEntity($values);
        TestCase::assertFalse($this->CampRoles->save($new));

        // CampRoleTypes
        $values = $this->getGood();
        $campRoleTypes = $this->CampRoles->CampRoleTypes->find('list')->toArray();

        $campRoleType = max(array_keys($campRoleTypes));

        $values['camp_role_type_id'] = $campRoleType;
        $new = $this->CampRoles->newEntity($values);
        TestCase::assertInstanceOf('App\Model\Entity\CampRole', $this->CampRoles->save($new));

        $values['camp_role_type_id'] = $campRoleType + 1;
        $new = $this->CampRoles->newEntity($values);
        TestCase::assertFalse($this->CampRoles->save($new));
    }
}

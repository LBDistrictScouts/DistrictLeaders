<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RolesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RolesTable Test Case
 */
class RolesTableTest extends TestCase
{
    use ModelTestTrait;

    /**
     * Test subject
     *
     * @var RolesTable
     */
    public RolesTable $Roles;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Roles') ? [] : ['className' => RolesTable::class];
        $this->Roles = $this->getTableLocator()->get('Roles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Roles);

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
            'role_type_id' => 1,
            'section_id' => 2,
            'user_id' => 2,
            'role_status_id' => 1,
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
        $actual = $this->Roles->get(1)->toArray();

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
            'role_type_id' => 1,
            'section_id' => 1,
            'user_id' => 1,
            'role_status_id' => 1,
            'user_contact_id' => 1,
        ];
        TestCase::assertEquals($expected, $actual);

        $count = $this->Roles->find('all')->count();
        TestCase::assertEquals(9, $count);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $good = $this->getGood();

        $new = $this->Roles->newEntity($good);
        TestCase::assertInstanceOf('App\Model\Entity\Role', $this->Roles->save($new));
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
        $users = $this->Roles->Users->find('list')->toArray();

        $user = max(array_keys($users));

        $values['user_id'] = $user;
        $new = $this->Roles->newEntity($values);
        TestCase::assertInstanceOf('App\Model\Entity\Role', $this->Roles->save($new));

        $values['user_id'] = $user + 1;
        $new = $this->Roles->newEntity($values);
        TestCase::assertFalse($this->Roles->save($new));

        // Sections
        $values = $this->getGood();
        $camps = $this->Roles->Sections->find('list')->toArray();

        $camp = max(array_keys($camps));

        $values['section_id'] = $camp;
        $new = $this->Roles->newEntity($values);
        TestCase::assertInstanceOf('App\Model\Entity\Role', $this->Roles->save($new));

        $values['section_id'] = $camp + 1;
        $new = $this->Roles->newEntity($values);
        TestCase::assertFalse($this->Roles->save($new));

        // RoleTypes
        $values = $this->getGood();
        $roleTypes = $this->Roles->RoleTypes->find('list')->toArray();

        $roleType = max(array_keys($roleTypes));

        $values['role_type_id'] = $roleType;
        $new = $this->Roles->newEntity($values);
        TestCase::assertInstanceOf('App\Model\Entity\Role', $this->Roles->save($new));

        $values['role_type_id'] = $roleType + 1;
        $new = $this->Roles->newEntity($values);
        TestCase::assertFalse($this->Roles->save($new));

        // RoleStatuses
        $values = $this->getGood();
        $roleStatuses = $this->Roles->RoleStatuses->find('list')->toArray();

        $roleStatus = max(array_keys($roleStatuses));

        $values['role_status_id'] = $roleStatus;
        $new = $this->Roles->newEntity($values);
        TestCase::assertInstanceOf('App\Model\Entity\Role', $this->Roles->save($new));

        $values['role_status_id'] = $roleStatus + 1;
        $new = $this->Roles->newEntity($values);
        TestCase::assertFalse($this->Roles->save($new));
    }
}

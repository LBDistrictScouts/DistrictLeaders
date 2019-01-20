<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AuditsTable;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AuditsTable Test Case
 */
class AuditsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AuditsTable
     */
    public $Audits;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Audits') ? [] : ['className' => AuditsTable::class];
        $this->Audits = TableRegistry::getTableLocator()->get('Audits', $config);

        $now = new Time('2018-12-26 23:22:30');
        Time::setTestNow($now);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Audits);

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
            'audit_field' => 'last_name',
            'audit_table' => 'Users',
            'original_value' => 'old',
            'modified_value' => 'new',
            'audit_record_id' => '1',
            'user_id' => 1,
            'change_date' => $date,
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
        $actual = $this->Audits->get(1)->toArray();

        $date = array_pop($actual);
        $this->assertInstanceOf('Cake\I18n\FrozenTime', $date);

        $expected = [
            'id' => 1,
            'audit_field' => 'first_name',
            'audit_table' => 'Users',
            'original_value' => 'old',
            'modified_value' => 'new',
            'user_id' => 1,
            'audit_record_id' => 1,
        ];
        $this->assertEquals($expected, $actual);

        $count = $this->Audits->find('all')->count();
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

        $new = $this->Audits->newEntity($good);
        $this->assertInstanceOf('App\Model\Entity\Audit', $this->Audits->save($new));

        $required = [
            'audit_field',
            'audit_table',
            'modified_value',
        ];

        foreach ($required as $require) {
            $reqArray = $good;
            unset($reqArray[$require]);
            $new = $this->Audits->newEntity($reqArray);
            $this->assertFalse($this->Audits->save($new));
        }

        $empties = [
            'original_value',
        ];

        foreach ($empties as $empty) {
            $reqArray = $good;
            $reqArray[$empty] = '';
            $new = $this->Audits->newEntity($reqArray);
            $this->assertInstanceOf('App\Model\Entity\Audit', $this->Audits->save($new));
        }

        $notEmpties = [
            'modified_value',
            'audit_table',
            'audit_field',
        ];

        foreach ($notEmpties as $not_empty) {
            $reqArray = $good;
            $reqArray[$not_empty] = '';
            $new = $this->Audits->newEntity($reqArray);
            $this->assertFalse($this->Audits->save($new));
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

        $users = $this->Audits->Users->find('list')->toArray();

        $user = max(array_keys($users));

        $values['user_id'] = $user;
        $new = $this->Audits->newEntity($values);
        $this->assertInstanceOf('App\Model\Entity\Audit', $this->Audits->save($new));

        $values['user_id'] = $user + 1;
        $new = $this->Audits->newEntity($values);
        $this->assertFalse($this->Audits->save($new));
    }
}

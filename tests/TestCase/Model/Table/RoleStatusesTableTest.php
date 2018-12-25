<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RoleStatusesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RoleStatusesTable Test Case
 */
class RoleStatusesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RoleStatusesTable
     */
    public $RoleStatuses;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.RoleStatuses',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('RoleStatuses') ? [] : ['className' => RoleStatusesTable::class];
        $this->RoleStatuses = TableRegistry::getTableLocator()->get('RoleStatuses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->RoleStatuses);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

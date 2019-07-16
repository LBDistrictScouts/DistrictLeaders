<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CapabilitiesRoleTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CapabilitiesRoleTypesTable Test Case
 */
class CapabilitiesRoleTypesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CapabilitiesRoleTypesTable
     */
    public $CapabilitiesRoleTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CapabilitiesRoleTypes',
        'app.Capabilities',
        'app.RoleTypes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CapabilitiesRoleTypes') ? [] : ['className' => CapabilitiesRoleTypesTable::class];
        $this->CapabilitiesRoleTypes = TableRegistry::getTableLocator()->get('CapabilitiesRoleTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CapabilitiesRoleTypes);

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
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

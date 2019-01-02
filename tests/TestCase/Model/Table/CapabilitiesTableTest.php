<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\Capability;
use App\Model\Table\CapabilitiesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

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
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $cap = $this->Capabilities->get(1)->toArray();

        debug($cap);

        $expected = [
            'id' => 1,
            'capability_code' => 'ALL',
            'capability' => 'SuperUser Permissions',
            'min_level' => 5
        ];

        $this->assertEquals($expected, $cap);
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

<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CampTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

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
        'app.Camps'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
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
    public function tearDown()
    {
        unset($this->CampTypes);

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

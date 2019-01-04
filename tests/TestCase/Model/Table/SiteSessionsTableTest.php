<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SiteSessionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SiteSessionsTable Test Case
 */
class SiteSessionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SiteSessionsTable
     */
    public $SiteSessions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.SiteSessions'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('SiteSessions') ? [] : ['className' => SiteSessionsTable::class];
        $this->SiteSessions = TableRegistry::getTableLocator()->get('SiteSessions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SiteSessions);

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
}

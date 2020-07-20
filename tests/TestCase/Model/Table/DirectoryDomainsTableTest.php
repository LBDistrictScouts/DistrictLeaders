<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DirectoryDomainsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DirectoryDomainsTable Test Case
 */
class DirectoryDomainsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DirectoryDomainsTable
     */
    protected $DirectoryDomains;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.DirectoryDomains',
        'app.Directories',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DirectoryDomains') ? [] : ['className' => DirectoryDomainsTable::class];
        $this->DirectoryDomains = TableRegistry::getTableLocator()->get('DirectoryDomains', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->DirectoryDomains);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

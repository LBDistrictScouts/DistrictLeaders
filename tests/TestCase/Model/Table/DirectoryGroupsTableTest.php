<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DirectoryGroupsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DirectoryGroupsTable Test Case
 */
class DirectoryGroupsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DirectoryGroupsTable
     */
    protected $DirectoryGroups;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.DirectoryGroups',
        'app.Directories',
        'app.RoleTypes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DirectoryGroups') ? [] : ['className' => DirectoryGroupsTable::class];
        $this->DirectoryGroups = TableRegistry::getTableLocator()->get('DirectoryGroups', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->DirectoryGroups);

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

<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DirectoryGroupsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DirectoryGroupsTable Test Case
 */
class DirectoryGroupsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var DirectoryGroupsTable
     */
    protected DirectoryGroupsTable $DirectoryGroups;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('DirectoryGroups') ? [] : ['className' => DirectoryGroupsTable::class];
        $this->DirectoryGroups = $this->getTableLocator()->get('DirectoryGroups', $config);
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

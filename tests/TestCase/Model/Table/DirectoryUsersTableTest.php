<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DirectoryUsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DirectoryUsersTable Test Case
 */
class DirectoryUsersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DirectoryUsersTable
     */
    protected $DirectoryUsers;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.DirectoryUsers',
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
        $config = TableRegistry::getTableLocator()->exists('DirectoryUsers') ? [] : ['className' => DirectoryUsersTable::class];
        $this->DirectoryUsers = TableRegistry::getTableLocator()->get('DirectoryUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->DirectoryUsers);

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

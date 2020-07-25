<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DirectoriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DirectoriesTable Test Case
 */
class DirectoriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DirectoriesTable
     */
    protected $Directories;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Directories',
        'app.DirectoryTypes',
        'app.DirectoryDomains',
        'app.DirectoryGroups',
        'app.DirectoryUsers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Directories') ? [] : ['className' => DirectoriesTable::class];
        $this->Directories = TableRegistry::getTableLocator()->get('Directories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Directories);

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

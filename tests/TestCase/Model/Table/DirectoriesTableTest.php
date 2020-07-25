<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\Directory;
use App\Model\Table\DirectoriesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DirectoriesTable Test Case
 */
class DirectoriesTableTest extends TestCase
{
    use ModelTestTrait;

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
        $config = $this->getTableLocator()->exists('Directories') ? [] : ['className' => DirectoriesTable::class];
        $this->Directories = $this->getTableLocator()->get('Directories', $config);
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
        $expected = [
            Directory::FIELD_ID => 1,
            Directory::FIELD_DIRECTORY => 'Lorem ipsum dolor sit amet',
            Directory::FIELD_CONFIGURATION_PAYLOAD => '',
            Directory::FIELD_DIRECTORY_TYPE_ID => 1,
            Directory::FIELD_ACTIVE => true,
            Directory::FIELD_CUSTOMER_REFERENCE => 'Lorem ipsu',
        ];

        $this->validateInitialise($expected, $this->Directories, 1);
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

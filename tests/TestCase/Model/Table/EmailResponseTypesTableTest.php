<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmailResponseTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmailResponseTypesTable Test Case
 */
class EmailResponseTypesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EmailResponseTypesTable
     */
    public $EmailResponseTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.EmailResponseTypes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EmailResponseTypes') ? [] : ['className' => EmailResponseTypesTable::class];
        $this->EmailResponseTypes = TableRegistry::getTableLocator()->get('EmailResponseTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EmailResponseTypes);

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

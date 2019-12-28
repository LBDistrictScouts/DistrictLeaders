<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\Document;
use App\Model\Table\DocumentsTable;
use App\Utility\TextSafe;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DocumentsTable Test Case
 */
class DocumentsTableTest extends TestCase
{
    use ModelTestTrait;

    /**
     * Test subject
     *
     * @var \App\Model\Table\DocumentsTable
     */
    public $Documents;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.FileTypes',
        'app.DocumentTypes',
        'app.Documents',
        'app.DocumentVersions',
        'app.DocumentEditions',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Documents') ? [] : ['className' => DocumentsTable::class];
        $this->Documents = TableRegistry::getTableLocator()->get('Documents', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Documents);

        parent::tearDown();
    }

    /**
     * Get Good Set Function
     *
     * @return array
     */
    private function getGood()
    {
        $good = [
            Document::FIELD_DOCUMENT_TYPE_ID => 1,
            Document::FIELD_DOCUMENT => TextSafe::shuffle(12),
        ];

        return $good;
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $expected = [
            Document::FIELD_ID => 1,
            Document::FIELD_DOCUMENT => 'Lorem ip',
            Document::FIELD_DOCUMENT_TYPE_ID => 1,
        ];
        $dates = [
            Document::FIELD_CREATED,
            Document::FIELD_MODIFIED,
            Document::FIELD_DELETED,
        ];
        $this->validateInitialise($expected, $this->Documents, 1, $dates);
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

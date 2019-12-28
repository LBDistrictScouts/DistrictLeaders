<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\DocumentType;
use App\Model\Entity\DocumentVersion;
use App\Model\Table\DocumentVersionsTable;
use App\Utility\TextSafe;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DocumentVersionsTable Test Case
 */
class DocumentVersionsTableTest extends TestCase
{
    use ModelTestTrait;

    /**
     * Test subject
     *
     * @var \App\Model\Table\DocumentVersionsTable
     */
    public $DocumentVersions;

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
        $config = TableRegistry::getTableLocator()->exists('DocumentVersions') ? [] : ['className' => DocumentVersionsTable::class];
        $this->DocumentVersions = TableRegistry::getTableLocator()->get('DocumentVersions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DocumentVersions);

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
            DocumentType::FIELD_DOCUMENT_TYPE => TextSafe::shuffle(15),
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
            DocumentVersion::FIELD_ID => 1,
            DocumentVersion::FIELD_DOCUMENT_ID => 1,
            DocumentVersion::FIELD_VERSION_NUMBER => 1,
        ];
        $dates = [
            DocumentVersion::FIELD_CREATED,
            DocumentVersion::FIELD_MODIFIED,
            DocumentVersion::FIELD_DELETED,
        ];
        $this->validateInitialise($expected, $this->DocumentVersions, 1, $dates);
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

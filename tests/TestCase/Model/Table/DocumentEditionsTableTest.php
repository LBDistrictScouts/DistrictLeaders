<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\DocumentEdition;
use App\Model\Table\DocumentEditionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DocumentEditionsTable Test Case
 */
class DocumentEditionsTableTest extends TestCase
{
    use ModelTestTrait;

    /**
     * Test subject
     *
     * @var \App\Model\Table\DocumentEditionsTable
     */
    public $DocumentEditions;

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
        $config = TableRegistry::getTableLocator()->exists('DocumentEditions') ? [] : ['className' => DocumentEditionsTable::class];
        $this->DocumentEditions = TableRegistry::getTableLocator()->get('DocumentEditions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DocumentEditions);

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
            DocumentEdition::FIELD_DOCUMENT_VERSION_ID => 1,
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
            DocumentEdition::FIELD_ID => 1,
            DocumentEdition::FIELD_DOCUMENT_VERSION_ID => 1,
            DocumentEdition::FIELD_FILE_TYPE_ID => 1,
            DocumentEdition::FIELD_MD5_HASH => 'Lorem ipsum dolor sit amet',
            DocumentEdition::FIELD_FILE_PATH => 'Lorem ipsum dolor sit amet',
        ];
        $dates = [
            DocumentEdition::FIELD_CREATED,
            DocumentEdition::FIELD_MODIFIED,
            DocumentEdition::FIELD_DELETED,
        ];
        $this->validateInitialise($expected, $this->DocumentEditions, 1, $dates);
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

    /**
     * Test getFilesystem method
     *
     * @return void
     */
    public function testGetFilesystem()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\DocumentEdition;
use App\Model\Entity\DocumentVersion;
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
        $versions = new DocumentVersionsTableTest();
        $goodVersion = $versions->getGood();
        $good = $this->DocumentEditions->DocumentVersions->newEntity($goodVersion);
        $good = $this->DocumentEditions->DocumentVersions->save($good);

        return [
            DocumentEdition::FIELD_DOCUMENT_VERSION_ID => $good->get(DocumentVersion::FIELD_ID),
            DocumentEdition::FIELD_FILE_TYPE_ID => 1,
            DocumentEdition::FIELD_MD5_HASH => 'Lorem ipsum dolor sit amet',
            DocumentEdition::FIELD_FILE_PATH => 'Lorem ipsum dolor sit amet',
            DocumentEdition::FIELD_FILENAME => 'Lorem ipsum dolor sit amet',
            DocumentEdition::FIELD_SIZE => 1,
        ];
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
            DocumentEdition::FIELD_FILENAME => 'Lorem ipsum dolor sit amet',
            DocumentEdition::FIELD_SIZE => 1,
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
        $goodData = $this->getGood();
        $good = $this->DocumentEditions->newEntity($goodData);
        TestCase::assertInstanceOf($this->DocumentEditions->getEntityClass(), $this->DocumentEditions->save($good));

        $required = [
            DocumentEdition::FIELD_DOCUMENT_VERSION_ID,
            DocumentEdition::FIELD_FILE_TYPE_ID,
            DocumentEdition::FIELD_FILE_PATH,
            DocumentEdition::FIELD_FILENAME,
        ];
        $this->validateRequired($required, $this->DocumentEditions, [$this, 'getGood']);

        $notRequired = [
            DocumentEdition::FIELD_MD5_HASH,
            DocumentEdition::FIELD_SIZE,
        ];
        $this->validateNotRequired($notRequired, $this->DocumentEditions, [$this, 'getGood']);

        $notEmpties = [
            DocumentEdition::FIELD_DOCUMENT_VERSION_ID,
            DocumentEdition::FIELD_FILE_TYPE_ID,
            DocumentEdition::FIELD_FILE_PATH,
            DocumentEdition::FIELD_FILENAME,
        ];
        $this->validateNotEmpties($notEmpties, $this->DocumentEditions, [$this, 'getGood']);

        $empties = [
            DocumentEdition::FIELD_MD5_HASH,
            DocumentEdition::FIELD_SIZE,
        ];
        $this->validateEmpties($empties, $this->DocumentEditions, [$this, 'getGood']);

        $maxLengths = [
            DocumentEdition::FIELD_FILENAME => 255,
            DocumentEdition::FIELD_FILE_PATH => 255,
            DocumentEdition::FIELD_MD5_HASH => 32,
        ];
        $this->validateMaxLengths($maxLengths, $this->DocumentEditions, [$this, 'getGood']);
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

    public function testUpload()
    {
        TestCase::markTestIncomplete();
        $entityData = [
            'path' => 'Group_Camp_2020_Poster.pdf',
            'filename' => 'Group_Camp_2020_Poster.pdf',
            'size' => 1477920,
            'mime' => 'application/pdf',
            'hash' => '8f9ae3cb199ea95cc4f2594cd4fd6033',
        ];

        $entityClass = $this->DocumentEditions->getEntityClass();
        $entity = new $entityClass($entityData);

        debug($entity);
    }
}

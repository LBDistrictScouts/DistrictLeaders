<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\DocumentVersion;
use App\Model\Table\DocumentVersionsTable;
use Cake\TestSuite\TestCase;
use Exception;

/**
 * App\Model\Table\DocumentVersionsTable Test Case
 */
class DocumentVersionsTableTest extends TestCase
{
    use ModelTestTrait;

    /**
     * Test subject
     *
     * @var DocumentVersionsTable
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
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('DocumentVersions') ? [] : ['className' => DocumentVersionsTable::class];
        $this->DocumentVersions = $this->getTableLocator()->get('DocumentVersions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->DocumentVersions);

        parent::tearDown();
    }

    /**
     * Get Good Set Function
     *
     * @return array
     */
    public function getGood()
    {
        try {
            return [
                DocumentVersion::FIELD_DOCUMENT_ID => 1,
                DocumentVersion::FIELD_VERSION_NUMBER => random_int(1, 9999999),
            ];
        } catch (Exception $exception) {
            return [];
        }
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
            DocumentVersion::FIELD_FIELD_MAPPING => [],
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
        $good = $this->getGood();

        $new = $this->DocumentVersions->newEntity($good);
        TestCase::assertInstanceOf('App\Model\Entity\DocumentVersion', $this->DocumentVersions->save($new));

        $required = [
            DocumentVersion::FIELD_VERSION_NUMBER,
            DocumentVersion::FIELD_DOCUMENT_ID,
        ];

        $this->validateRequired($required, $this->DocumentVersions, [$this, 'getGood']);

        $notEmpties = [
            DocumentVersion::FIELD_VERSION_NUMBER,
            DocumentVersion::FIELD_DOCUMENT_ID,
        ];

        $this->validateNotEmpties($notEmpties, $this->DocumentVersions, [$this, 'getGood']);
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->validateExistsRule(
            DocumentVersion::FIELD_DOCUMENT_ID,
            $this->DocumentVersions,
            $this->DocumentVersions->Documents,
            [$this, 'getGood']
        );
        $this->validateUniqueRule(
            [DocumentVersion::FIELD_VERSION_NUMBER, DocumentVersion::FIELD_DOCUMENT_ID],
            $this->DocumentVersions,
            [$this, 'getGood']
        );
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testFindDocumentList()
    {
        $expected = [
            1 => 'Lorem ipsum dolor sit amet - 1',
        ];

        $actual = $this->DocumentVersions->find('documentList')->toArray();
        TestCase::assertEquals($expected, $actual);
    }
}

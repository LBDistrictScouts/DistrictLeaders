<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\DocumentType;
use App\Model\Table\DocumentTypesTable;
use App\Utility\TextSafe;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DocumentTypesTable Test Case
 */
class DocumentTypesTableTest extends TestCase
{
    use ModelTestTrait;

    /**
     * Test subject
     *
     * @var \App\Model\Table\DocumentTypesTable
     */
    public $DocumentTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.DocumentTypes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DocumentTypes') ? [] : ['className' => DocumentTypesTable::class];
        $this->DocumentTypes = TableRegistry::getTableLocator()->get('DocumentTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DocumentTypes);

        parent::tearDown();
    }

    /**
     * Get Good Set Function
     *
     * @return array
     */
    public function getGood()
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
            DocumentType::FIELD_ID => 1,
            DocumentType::FIELD_DOCUMENT_TYPE => 'Lorem ipsum dolor sit amet',
        ];
        $this->validateInitialise($expected, $this->DocumentTypes, 1);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $required = [
            DocumentType::FIELD_DOCUMENT_TYPE,
        ];
        $this->validateRequired($required, $this->DocumentTypes, [$this, 'getGood']);

        $notEmpty = [
            DocumentType::FIELD_DOCUMENT_TYPE,
        ];
        $this->validateNotEmpties($notEmpty, $this->DocumentTypes, [$this, 'getGood']);
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->validateUniqueRule(DocumentType::FIELD_DOCUMENT_TYPE, $this->DocumentTypes, [$this, 'getGood']);
    }
}

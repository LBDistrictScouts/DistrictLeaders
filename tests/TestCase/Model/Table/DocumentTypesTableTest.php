<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\DocumentType;
use App\Model\Table\DocumentTypesTable;
use App\Utility\TextSafe;
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
     * @var DocumentTypesTable
     */
    protected DocumentTypesTable $DocumentTypes;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('DocumentTypes') ? [] : ['className' => DocumentTypesTable::class];
        $this->DocumentTypes = $this->getTableLocator()->get('DocumentTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->DocumentTypes);

        parent::tearDown();
    }

    /**
     * Get Good Set Function
     *
     * @return array
     */
    public function getGood(): array
    {
        return [
            DocumentType::FIELD_DOCUMENT_TYPE => TextSafe::shuffle(15),
        ];
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize(): void
    {
        $expected = [
            DocumentType::FIELD_ID => 1,
            DocumentType::FIELD_DOCUMENT_TYPE => 'Lorem ipsum dolor sit amet',
            DocumentType::FIELD_SPECIAL_CAPABILITY => 'HISTORY',
        ];
        $this->validateInitialise($expected, $this->DocumentTypes, 1);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $required = [
            DocumentType::FIELD_DOCUMENT_TYPE,
        ];
        $this->validateRequired($required, $this->DocumentTypes, [$this, 'getGood']);

        $notEmpty = [
            DocumentType::FIELD_DOCUMENT_TYPE,
        ];
        $this->validateNotEmpties($notEmpty, $this->DocumentTypes, [$this, 'getGood']);

        $notRequired = [
            DocumentType::FIELD_SPECIAL_CAPABILITY,
        ];
        $this->validateNotRequired($notRequired, $this->DocumentTypes, [$this, 'getGood']);

        $empties = [
            DocumentType::FIELD_SPECIAL_CAPABILITY,
        ];
        $this->validateEmpties($empties, $this->DocumentTypes, [$this, 'getGood']);
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->validateUniqueRule(DocumentType::FIELD_DOCUMENT_TYPE, $this->DocumentTypes, [$this, 'getGood']);
    }
}

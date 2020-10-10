<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\SectionType;
use App\Model\Table\SectionTypesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SectionTypesTable Test Case
 */
class SectionTypesTableTest extends TestCase
{
    use ModelTestTrait;

    /**
     * Test subject
     *
     * @var \App\Model\Table\SectionTypesTable
     */
    protected $SectionTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.SectionTypes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('SectionTypes') ? [] : ['className' => SectionTypesTable::class];
        $this->SectionTypes = $this->getTableLocator()->get('SectionTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->SectionTypes);

        parent::tearDown();
    }

    /**
     * Get Good Set Function
     *
     * @return array
     */
    private function getGood()
    {
        return [
            SectionType::FIELD_SECTION_TYPE => 'Llamas',
            SectionType::FIELD_SECTION_TYPE_CODE => 'l',
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
            SectionType::FIELD_ID => 1,
            SectionType::FIELD_SECTION_TYPE => 'Beavers',
            SectionType::FIELD_IS_YOUNG_PERSON_SECTION => true,
            SectionType::FIELD_SECTION_TYPE_CODE => 'l',
        ];
        $this->validateInitialise($expected, $this->SectionTypes, 8);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $good = $this->getGood();

        $new = $this->SectionTypes->newEntity($good);
        TestCase::assertInstanceOf(SectionType::class, $this->SectionTypes->save($new));

        $required = [
            SectionType::FIELD_SECTION_TYPE,
            SectionType::FIELD_SECTION_TYPE_CODE,
        ];
        $this->validateRequired($required, $this->SectionTypes, [$this, 'getGood']);

        $notEmpties = [
            SectionType::FIELD_SECTION_TYPE,
            SectionType::FIELD_SECTION_TYPE_CODE,
        ];
        $this->validateNotEmpties($notEmpties, $this->SectionTypes, [$this, 'getGood']);

        $maxLengths = [
            SectionType::FIELD_SECTION_TYPE => 255,
//            SectionType::FIELD_SECTION_TYPE_CODE => 1,
        ];
        $this->validateMaxLengths($maxLengths, $this->SectionTypes, [$this, 'getGood']);
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->validateUniqueRule(SectionType::FIELD_SECTION_TYPE, $this->SectionTypes, [$this, 'getGood']);
    }
}

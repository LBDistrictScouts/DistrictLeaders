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
     * @var SectionTypesTable
     */
    protected $SectionTypes;

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

    /**
     * @return array[]
     */
    public function provideFindOrMake()
    {
        return [
            'Existing Section String' => [
                'Beavers',
                null,
                true,
            ],
            'Null Section Type Error' => [
                null,
                null,
                false,
            ],
            'New Section, No Type Code' => [
                'Llama',
                null,
                true,
            ],
            'New Section, Included Type Code' => [
                'Llama',
                'l',
                true,
            ],
        ];
    }

    /**
     * Test findOrMake method
     *
     * @dataProvider provideFindOrMake
     * @param string|null $sectionType The Nullable Section Type Value
     * @param string|null $typeCode The Nullable Type Code Value
     * @param bool $expected The Expected Outcome
     * @return void
     */
    public function testFindOrMake(?string $sectionType, ?string $typeCode, bool $expected): void
    {
        if (!$expected) {
            $this->expectException('TypeError');
        }

        $result = $this->SectionTypes->findOrMake($sectionType, $typeCode);

        if ($expected) {
            TestCase::assertInstanceOf(SectionType::class, $result);
        }
    }
}

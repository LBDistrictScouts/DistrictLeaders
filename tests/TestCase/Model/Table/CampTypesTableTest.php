<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\CampType;
use App\Model\Table\CampTypesTable;
use App\Utility\TextSafe;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CampTypesTable Test Case
 */
class CampTypesTableTest extends TestCase
{
    use ModelTestTrait;

    /**
     * Test subject
     *
     * @var CampTypesTable
     */
    public CampTypesTable $CampTypes;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CampTypes') ? [] : ['className' => CampTypesTable::class];
        $this->CampTypes = $this->getTableLocator()->get('CampTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->CampTypes);

        parent::tearDown();
    }

    /**
     * Get Good Set Function
     *
     * @return array
     */
    private function getGood(): array
    {
        return [
            CampType::FIELD_CAMP_TYPE => ucwords(TextSafe::shuffle(5) . ' ' . TextSafe::shuffle(5)),
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
            CampType::FIELD_ID => 1,
            CampType::FIELD_CAMP_TYPE => 'Lorem ipsum sit amet',
        ];

        $this->validateInitialise($expected, $this->CampTypes, 1);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $good = $this->getGood();

        $new = $this->CampTypes->newEntity($good);
        TestCase::assertInstanceOf('App\Model\Entity\CampType', $this->CampTypes->save($new));

        $required = [
            CampType::FIELD_CAMP_TYPE,
        ];

        $this->validateRequired($required, $this->CampTypes, [$this, 'getGood']);

        $notEmpties = [
            CampType::FIELD_CAMP_TYPE,
        ];

        $this->validateNotEmpties($notEmpties, $this->CampTypes, [$this, 'getGood']);

        $maxLengths = [
            CampType::FIELD_CAMP_TYPE => 30,
        ];

        $this->validateMaxLengths($maxLengths, $this->CampTypes, [$this, 'getGood']);
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->validateUniqueRule(CampType::FIELD_CAMP_TYPE, $this->CampTypes, [$this, 'getGood']);
    }
}

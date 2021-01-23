<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\CampType;
use App\Model\Table\CampTypesTable;
use App\Test\Factory\CampTypeFactory;
use App\Utility\TextSafe;
use Cake\TestSuite\TestCase;
use Cake\Utility\Security;
use Faker\Generator;

/**
 * App\Model\Table\CampTypesTable Test Case
 */
class CampTypesTableTest extends TestCase
{
    use ModelTestTrait;

    /**
     * Test subject
     *
     * @var \App\Model\Table\CampTypesTable
     */
    public $CampTypes;

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
        return CampTypeFactory::getGood();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize(): void
    {
        $this->validateAutoInitialise($this->CampTypes);
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

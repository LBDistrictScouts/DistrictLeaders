<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\DirectoryType;
use App\Model\Table\DirectoryTypesTable;
use App\Utility\TextSafe;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DirectoryTypesTable Test Case
 */
class DirectoryTypesTableTest extends TestCase
{
    use LocatorAwareTrait;
    use ModelTestTrait;

    /**
     * Test subject
     *
     * @var \App\Model\Table\DirectoryTypesTable
     */
    protected $DirectoryTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.DirectoryTypes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('DirectoryTypes') ? [] : ['className' => DirectoryTypesTable::class];
        $this->DirectoryTypes = $this->getTableLocator()->get('DirectoryTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->DirectoryTypes);

        parent::tearDown();
    }

    /**
     * Get Good Set Function
     *
     * @return array
     */
    public function getGood()
    {
        return [
            DirectoryType::FIELD_DIRECTORY_TYPE => TextSafe::shuffle(15),
            DirectoryType::FIELD_DIRECTORY_TYPE_CODE => TextSafe::shuffle(3),
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
            DirectoryType::FIELD_ID => 1,
            DirectoryType::FIELD_DIRECTORY_TYPE => 'Google G Suite',
            DirectoryType::FIELD_DIRECTORY_TYPE_CODE => 'GOOGLE',
        ];
        $this->validateInitialise($expected, $this->DirectoryTypes, 1);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $good = $this->getGood();

        $new = $this->DirectoryTypes->newEntity($good);
        TestCase::assertInstanceOf(DirectoryType::class, $this->DirectoryTypes->save($new));

        $fields = [
            DirectoryType::FIELD_DIRECTORY_TYPE,
            DirectoryType::FIELD_DIRECTORY_TYPE_CODE,
        ];
        $this->validateRequired($fields, $this->DirectoryTypes, [$this, 'getGood']);
        $this->validateNotEmpties($fields, $this->DirectoryTypes, [$this, 'getGood']);

        $maxLengths = [
            DirectoryType::FIELD_DIRECTORY_TYPE => 64,
            DirectoryType::FIELD_DIRECTORY_TYPE_CODE => 64,
        ];
        $this->validateMaxLengths($maxLengths, $this->DirectoryTypes, [$this, 'getGood']);
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $uniques = [
            DirectoryType::FIELD_DIRECTORY_TYPE_CODE,
            DirectoryType::FIELD_DIRECTORY_TYPE,
        ];
        $this->validateUniqueRules($uniques, $this->DirectoryTypes, [$this, 'getGood']);
    }

    /**
     * Test installBase method
     *
     * @return void
     */
    public function testInstallBase(): void
    {
        $this->validateInstallBase($this->DirectoryTypes);
    }
}

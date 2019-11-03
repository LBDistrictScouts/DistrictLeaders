<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\FileType;
use App\Model\Table\FileTypesTable;
use App\Utility\TextSafe;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FileTypesTable Test Case
 */
class FileTypesTableTest extends TestCase
{
    use ModelTestTrait;

    /**
     * Test subject
     *
     * @var \App\Model\Table\FileTypesTable
     */
    public $FileTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.FileTypes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('FileTypes') ? [] : ['className' => FileTypesTable::class];
        $this->FileTypes = TableRegistry::getTableLocator()->get('FileTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FileTypes);

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
            FileType::FIELD_FILE_TYPE => TextSafe::shuffle(15),
            FileType::FIELD_FILE_EXTENSION => TextSafe::shuffle(3),
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
            FileType::FIELD_ID => 1,
            FileType::FIELD_FILE_TYPE => 'Word',
            FileType::FIELD_FILE_EXTENSION => 'docx'
        ];
        $this->validateInitialise($expected, $this->FileTypes, 2);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $good = $this->getGood();

        $new = $this->FileTypes->newEntity($good);
        TestCase::assertInstanceOf(FileType::class, $this->FileTypes->save($new));

        $required = [
            FileType::FIELD_FILE_EXTENSION,
            FileType::FIELD_FILE_TYPE,
        ];

        $this->validateRequired($required, $this->FileTypes, [$this, 'getGood']);

        $notEmpties = [
            FileType::FIELD_FILE_TYPE,
            FileType::FIELD_FILE_EXTENSION,
        ];

        $this->validateNotEmpties($notEmpties, $this->FileTypes, [$this, 'getGood']);

        $maxLengths = [
            FileType::FIELD_FILE_TYPE => 31,
            FileType::FIELD_FILE_EXTENSION => 10,
        ];

        $this->validateMaxLengths($maxLengths, $this->FileTypes, [$this, 'getGood']);
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->validateUniqueRule(FileType::FIELD_FILE_TYPE, $this->FileTypes, [$this, 'getGood']);
        $this->validateUniqueRule(FileType::FIELD_FILE_EXTENSION, $this->FileTypes, [$this, 'getGood']);
    }

    /**
     * Test installBaseStatuses method
     *
     * @return void
     */
    public function testInstallBaseTypes()
    {
        $this->validateInstallBase($this->FileTypes);
    }
}

<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\FileType;
use App\Model\Table\FileTypesTable;
use App\Utility\TextSafe;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FileTypesTable Test Case
 */
class FileTypesTableTest extends TestCase
{
    use ModelTestTrait;
    use LocatorAwareTrait;

    /**
     * Test subject
     *
     * @var FileTypesTable
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
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('FileTypes') ? [] : ['className' => FileTypesTable::class];
        $this->FileTypes = $this->getTableLocator()->get('FileTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
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
            FileType::FIELD_MIME => strtolower(TextSafe::shuffle(8)) . '/' . strtolower(TextSafe::shuffle(3)),
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
            FileType::FIELD_FILE_EXTENSION => 'docx',
            FileType::FIELD_MIME => 'application/docx',
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
            FileType::FIELD_MIME,
        ];

        $this->validateRequired($required, $this->FileTypes, [$this, 'getGood']);

        $notEmpties = [
            FileType::FIELD_FILE_TYPE,
            FileType::FIELD_FILE_EXTENSION,
            FileType::FIELD_MIME,
        ];

        $this->validateNotEmpties($notEmpties, $this->FileTypes, [$this, 'getGood']);

        $maxLengths = [
            FileType::FIELD_FILE_TYPE => 31,
            FileType::FIELD_FILE_EXTENSION => 10,
            FileType::FIELD_MIME => 32,
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
        $this->validateUniqueRule(FileType::FIELD_MIME, $this->FileTypes, [$this, 'getGood']);
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

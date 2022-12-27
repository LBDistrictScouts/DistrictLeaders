<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\Directory;
use App\Model\Table\DirectoriesTable;
use App\Utility\TextSafe;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DirectoriesTable Test Case
 */
class DirectoriesTableTest extends TestCase
{
    use ModelTestTrait;

    /**
     * Test subject
     *
     * @var DirectoriesTable
     */
    protected DirectoriesTable $Directories;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Directories') ? [] : ['className' => DirectoriesTable::class];
        $this->Directories = $this->getTableLocator()->get('Directories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Directories);

        parent::tearDown();
    }

    public function getGood(): array
    {
        return [
            Directory::FIELD_DIRECTORY => TextSafe::shuffle(8) . ' Directory',
            Directory::FIELD_DIRECTORY_TYPE_ID => 1,
            Directory::FIELD_ACTIVE => true,
            Directory::FIELD_CUSTOMER_REFERENCE => TextSafe::shuffle(10),
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
            Directory::FIELD_ID => 1,
            Directory::FIELD_DIRECTORY => 'Lorem ipsum dolor sit amet',
            Directory::FIELD_DIRECTORY_TYPE_ID => 1,
            Directory::FIELD_ACTIVE => true,
            Directory::FIELD_CUSTOMER_REFERENCE => 'Lorem ipsu',
        ];

        $this->validateInitialise($expected, $this->Directories, 1);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $new = $this->Directories->newEntity($this->getGood());
        TestCase::assertInstanceOf(Directory::class, $this->Directories->save($new));

        $required = [
            Directory::FIELD_DIRECTORY,
        ];
        $this->validateRequired($required, $this->Directories, [$this, 'getGood']);

        $notRequired = [
            Directory::FIELD_CUSTOMER_REFERENCE,
            Directory::FIELD_AUTHORISATION_TOKEN,
            Directory::FIELD_ACTIVE,
        ];
        $this->validateNotRequired($notRequired, $this->Directories, [$this, 'getGood']);

        $empties = [
            Directory::FIELD_CUSTOMER_REFERENCE,
            Directory::FIELD_AUTHORISATION_TOKEN,
        ];
        $this->validateEmpties($empties, $this->Directories, [$this, 'getGood']);

        $notEmpties = [
            Directory::FIELD_ACTIVE,
            Directory::FIELD_DIRECTORY,
        ];
        $this->validateNotEmpties($notEmpties, $this->Directories, [$this, 'getGood']);

        $maxLengths = [
            Directory::FIELD_DIRECTORY => 64,
            Directory::FIELD_CUSTOMER_REFERENCE => 12,
        ];
        $this->validateMaxLengths($maxLengths, $this->Directories, [$this, 'getGood']);
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $uniques = [
            Directory::FIELD_DIRECTORY,
            Directory::FIELD_CUSTOMER_REFERENCE,
        ];
        $this->validateUniqueRules($uniques, $this->Directories, [$this, 'getGood']);

        $this->validateExistsRule(
            Directory::FIELD_DIRECTORY_TYPE_ID,
            $this->Directories,
            $this->Directories->DirectoryTypes,
            [$this, 'getGood']
        );
    }
}

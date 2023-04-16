<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\DocumentEdition;
use App\Model\Entity\DocumentVersion;
use App\Model\Table\DocumentEditionsTable;
use Cake\Core\Configure;
use Cake\ORM\Table;
use Cake\TestSuite\TestCase;
use FilesystemIterator;
use League\Flysystem\Local\LocalFilesystemAdapter;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * App\Model\Table\DocumentEditionsTable Test Case
 */
class DocumentEditionsTableTest extends TestCase
{
    use ModelTestTrait;

    /**
     * Test subject
     *
     * @var DocumentEditionsTable
     */
    public Table|DocumentEditionsTable $DocumentEditions;

    /**
     * @var LocalFilesystemAdapter
     */
    protected LocalFilesystemAdapter $Adapter;

    /**
     * @var string
     */
    protected string $Root;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.FileTypes',
        'app.DocumentTypes',
        'app.Documents',
        'app.DocumentVersions',
        'app.DocumentEditions',
    ];

    private array $fileSystemTestConfig = [
        'default' => [
            'adapter' => 'Local',
            'adapterArguments' => [ TMP . 'files' ],
            'entityClass' => 'App\Model\Entity\DocumentEdition',
        ],
        'local' => [
            'adapter' => 'Local',
            'adapterArguments' => [ TMP . 'files' ],
            'entityClass' => 'App\Model\Entity\DocumentEdition',
        ],
        'cache' => [
            'adapter' => 'Local',
            'adapterArguments' => [ TMP . 'cached' ],
        ],
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('DocumentEditions') ? [] : ['className' => DocumentEditionsTable::class];
        $this->DocumentEditions = $this->getTableLocator()->get('DocumentEditions', $config);

        Configure::write('Filesystem', $this->fileSystemTestConfig);

        $this->Root = __DIR__ . '/files/';
        $this->Adapter = new LocalFilesystemAdapter($this->Root);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->DocumentEditions);

        $it = new RecursiveDirectoryIterator($this->Root, FilesystemIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator(
            $it,
            RecursiveIteratorIterator::CHILD_FIRST
        );
        foreach ($files as $file) {
            if ($file->getFilename() === '.' || $file->getFilename() === '..') {
                continue;
            }
            if ($file->isDir()) {
                rmdir($file->getRealPath());
            } else {
                unlink($file->getPathname());
            }
        }

        parent::tearDown();
    }

    /**
     * Get Good Set Function
     *
     * @return array
     */
    private function getGood()
    {
        $versions = new DocumentVersionsTableTest();
        $goodVersion = $versions->getGood();
        $good = $this->DocumentEditions->DocumentVersions->newEntity($goodVersion);
        $good = $this->DocumentEditions->DocumentVersions->save($good);

        return [
            DocumentEdition::FIELD_DOCUMENT_VERSION_ID => $good->get(DocumentVersion::FIELD_ID),
            DocumentEdition::FIELD_FILE_TYPE_ID => 1,
            DocumentEdition::FIELD_MD5_HASH => 'Lorem ipsum dolor sit amet',
            DocumentEdition::FIELD_FILE_PATH => 'Lorem ipsum dolor sit amet',
            DocumentEdition::FIELD_FILENAME => 'Lorem ipsum dolor sit amet',
            DocumentEdition::FIELD_SIZE => 1,
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
            DocumentEdition::FIELD_ID => 1,
            DocumentEdition::FIELD_DOCUMENT_VERSION_ID => 1,
            DocumentEdition::FIELD_FILE_TYPE_ID => 1,
            DocumentEdition::FIELD_MD5_HASH => 'Lorem ipsum dolor sit amet',
            DocumentEdition::FIELD_FILE_PATH => 'Lorem ipsum dolor sit amet',
            DocumentEdition::FIELD_FILENAME => 'Lorem ipsum dolor sit amet',
            DocumentEdition::FIELD_SIZE => 1,
        ];
        $dates = [
            DocumentEdition::FIELD_CREATED,
            DocumentEdition::FIELD_MODIFIED,
            DocumentEdition::FIELD_DELETED,
        ];
        $this->validateInitialise($expected, $this->DocumentEditions, 1, $dates);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $goodData = $this->getGood();
        $good = $this->DocumentEditions->newEntity($goodData);
        TestCase::assertInstanceOf($this->DocumentEditions->getEntityClass(), $this->DocumentEditions->save($good));

        $required = [
            DocumentEdition::FIELD_DOCUMENT_VERSION_ID,
            DocumentEdition::FIELD_FILE_TYPE_ID,
            DocumentEdition::FIELD_FILE_PATH,
            DocumentEdition::FIELD_FILENAME,
        ];
        $this->validateRequired($required, $this->DocumentEditions, [$this, 'getGood']);

        $notRequired = [
            DocumentEdition::FIELD_MD5_HASH,
            DocumentEdition::FIELD_SIZE,
        ];
        $this->validateNotRequired($notRequired, $this->DocumentEditions, [$this, 'getGood']);

        $notEmpties = [
            DocumentEdition::FIELD_DOCUMENT_VERSION_ID,
            DocumentEdition::FIELD_FILE_TYPE_ID,
            DocumentEdition::FIELD_FILE_PATH,
            DocumentEdition::FIELD_FILENAME,
        ];
        $this->validateNotEmpties($notEmpties, $this->DocumentEditions, [$this, 'getGood']);

        $empties = [
            DocumentEdition::FIELD_MD5_HASH,
            DocumentEdition::FIELD_SIZE,
        ];
        $this->validateEmpties($empties, $this->DocumentEditions, [$this, 'getGood']);

        $maxLengths = [
            DocumentEdition::FIELD_FILENAME => 255,
            DocumentEdition::FIELD_FILE_PATH => 255,
            DocumentEdition::FIELD_MD5_HASH => 40,
        ];
        $this->validateMaxLengths($maxLengths, $this->DocumentEditions, [$this, 'getGood']);
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getFilesystem method
     *
     * @return void
     */
    public function testGetFilesystem(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    public function testUpload()
    {
        TestCase::markTestIncomplete();
        //$entityData = [
        //    'uploadedFile' => [
        //        'path' => TESTS . 'dummy.png',
        //        'filename' => 'dummy.png',
        //        'size' => 59992,
        //        'mime' => 'image/png',
        //        'hash' => '2164a354104c1c01c26a17dce1de7b2ee01d30ac',
        //    ],
        //];
        //
        ////        TestCase::
        //
        //
        //$return = $this->DocumentEditions->uploadDocument($entityData);
        //debug($return);
        //
        //TestCase::assertInstanceOf(DocumentEdition::class, $return);
    }
}

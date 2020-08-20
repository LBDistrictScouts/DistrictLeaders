<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\CompassRecord;
use App\Model\Table\CompassRecordsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CompassRecordsTable Test Case
 */
class CompassRecordsTableTest extends TestCase
{
    use ModelTestTrait;

    /**
     * Test subject
     *
     * @var \App\Model\Table\CompassRecordsTable
     */
    protected $CompassRecords;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.FileTypes',
        'app.DocumentTypes',
        'app.Documents',
        'app.DocumentVersions',
        'app.DocumentEditions',
        'app.CompassRecords',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CompassRecords') ? [] : ['className' => CompassRecordsTable::class];
        $this->CompassRecords = $this->getTableLocator()->get('CompassRecords', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->CompassRecords);

        parent::tearDown();
    }

    public function getGood(): array
    {
        $data = [
            CompassRecord::FIELD_DOCUMENT_VERSION_ID => 1,
            CompassRecord::FIELD_TITLE => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_FORENAMES => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_SURNAME => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_ADDRESS => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_ADDRESS_LINE1 => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_ADDRESS_LINE2 => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_ADDRESS_LINE3 => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_ADDRESS_TOWN => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_ADDRESS_COUNTY => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_POSTCODE => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_ADDRESS_COUNTRY => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_ROLE => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_LOCATION => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_PHONE => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_EMAIL => 'jacob@fish.com',
        ];

        try {
            $data[CompassRecord::FIELD_MEMBERSHIP_NUMBER] = random_int(111111, 999999) . random_int(11, 99);
        } catch (\Exception $e) {
            $data[CompassRecord::FIELD_MEMBERSHIP_NUMBER] = 2901210;
        }

        return $data;
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize(): void
    {
        $expected = [
            CompassRecord::FIELD_ID => 1,
            CompassRecord::FIELD_DOCUMENT_VERSION_ID => 1,
            CompassRecord::FIELD_MEMBERSHIP_NUMBER => 1,
            CompassRecord::FIELD_TITLE => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_FORENAMES => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_SURNAME => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_ADDRESS => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_ADDRESS_LINE1 => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_ADDRESS_LINE2 => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_ADDRESS_LINE3 => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_ADDRESS_TOWN => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_ADDRESS_COUNTY => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_POSTCODE => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_ADDRESS_COUNTRY => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_ROLE => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_LOCATION => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_PHONE => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_EMAIL => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_PROVISIONAL => false,
            CompassRecord::FIELD_CLEAN_ROLE => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_CLEAN_GROUP => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_CLEAN_SECTION => 'Lorem ipsum dolor sit amet Group',
            CompassRecord::FIELD_FIRST_NAME => 'Lorem',
            CompassRecord::FIELD_LAST_NAME => 'Lorem Ipsum Dolor Sit Amet',
            CompassRecord::FIELD_CLEAN_SECTION_TYPE => 'Group',
        ];

        $this->validateInitialise($expected, $this->CompassRecords, 1);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $good = $this->getGood();

        $new = $this->CompassRecords->newEntity($good);
        TestCase::assertInstanceOf('App\Model\Entity\CompassRecord', $this->CompassRecords->save($new));

        $required = [
            CompassRecord::FIELD_DOCUMENT_VERSION_ID,
            CompassRecord::FIELD_MEMBERSHIP_NUMBER,
        ];

        $this->validateRequired($required, $this->CompassRecords, [$this, 'getGood']);
        $this->validateNotEmpties($required, $this->CompassRecords, [$this, 'getGood']);

        $notRequired = [
            CompassRecord::FIELD_TITLE,
            CompassRecord::FIELD_FORENAMES,
            CompassRecord::FIELD_SURNAME,
            CompassRecord::FIELD_ADDRESS,
            CompassRecord::FIELD_ADDRESS_LINE1,
            CompassRecord::FIELD_ADDRESS_LINE2,
            CompassRecord::FIELD_ADDRESS_LINE3,
            CompassRecord::FIELD_ADDRESS_TOWN,
            CompassRecord::FIELD_ADDRESS_COUNTY,
            CompassRecord::FIELD_POSTCODE,
            CompassRecord::FIELD_ADDRESS_COUNTRY,
            CompassRecord::FIELD_ROLE,
            CompassRecord::FIELD_LOCATION,
            CompassRecord::FIELD_PHONE,
            CompassRecord::FIELD_EMAIL,
        ];
        $this->validateNotRequired($notRequired, $this->CompassRecords, [$this, 'getGood']);
        $this->validateEmpties($notRequired, $this->CompassRecords, [$this, 'getGood']);
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->validateUniqueRule([
            CompassRecord::FIELD_MEMBERSHIP_NUMBER,
            CompassRecord::FIELD_DOCUMENT_VERSION_ID,
        ], $this->CompassRecords, [$this, 'getGood']);

        $this->validateExistsRule(
            CompassRecord::FIELD_DOCUMENT_VERSION_ID,
            $this->CompassRecords,
            $this->CompassRecords->DocumentVersions,
            [$this, 'getGood']
        );
    }
}

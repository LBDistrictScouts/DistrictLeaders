<?php

declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\CompassRecord;
use App\Model\Entity\DirectoryUser;
use App\Model\Entity\User;
use App\Model\Entity\UserContact;
use App\Model\Table\CompassRecordsTable;
use App\Model\Table\UsersTable;
use Cake\TestSuite\TestCase;
use Exception;

/**
 * App\Model\Table\CompassRecordsTable Test Case
 */
class CompassRecordsTableTest extends TestCase
{
    use ModelTestTrait;

    /**
     * Test subject
     *
     * @var CompassRecordsTable
     */
    protected CompassRecordsTable $CompassRecords;

    /**
     * Test subject
     *
     * @var UsersTable
     */
    protected UsersTable $Users;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $config = $this->getTableLocator()->exists('CompassRecords') ? [] : [
            'className' => CompassRecordsTable::class,
            'connectionName' => 'test',
        ];
        $this->CompassRecords = $this->getTableLocator()->get('CompassRecords', $config);

        $config = $this->getTableLocator()->exists('Users') ? [] : [
            'className' => UsersTable::class,
            'connectionName' => 'test',
        ];
        $this->Users = $this->getTableLocator()->get('Users', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->CompassRecords);
        unset($this->Users);

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
            CompassRecord::FIELD_ROLE => 'Assistant Section Leader - Beaver Scouts',
            CompassRecord::FIELD_LOCATION => '8th Fish - Beaver Scout 1',
            CompassRecord::FIELD_PHONE => '01293 983982',
            CompassRecord::FIELD_EMAIL => 'jacob@8thfish.co.uk',
        ];

        try {
            $data[CompassRecord::FIELD_MEMBERSHIP_NUMBER] = random_int(111111, 999999) . random_int(11, 99);
        } catch (Exception $e) {
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
            CompassRecord::FIELD_FORENAMES => 'Joseph Gotlamb',
            CompassRecord::FIELD_SURNAME => 'Jingles',
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
            CompassRecord::FIELD_EMAIL => 'octopus@monkey.goat',
            CompassRecord::FIELD_PROVISIONAL => true,
            CompassRecord::FIELD_CLEAN_ROLE => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_CLEAN_GROUP => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_CLEAN_SECTION => 'Lorem ipsum dolor sit amet Group',
            CompassRecord::FIELD_FIRST_NAME => 'Joseph',
            CompassRecord::FIELD_LAST_NAME => 'Jingles',
            CompassRecord::FIELD_CLEAN_SECTION_TYPE => 'Group',
            CompassRecord::FIELD_FULL_NAME => 'Joseph Jingles',
            CompassRecord::FIELD_PREFERRED_FORENAME => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_START_DATE => 'Lorem ipsum dolor ',
            CompassRecord::FIELD_ROLE_STATUS => 'Lorem ipsum dolor ',
            CompassRecord::FIELD_LINE_MANAGER_NUMBER => 1,
            CompassRecord::FIELD_DISTRICT => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_SCOUT_GROUP => 'Lorem ipsum dolor sit amet',
            CompassRecord::FIELD_SCOUT_GROUP_SECTION => 'Lorem ipsum dolor sit amet',
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

    /**
     * Test beforeRules method
     *
     * @return void
     */
    public function testBeforeRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test autoMerge method
     *
     * @return void
     */
    public function testDoAutoMerge(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test parseImportedData method
     *
     * @return void
     */
    public function testParseImportedData(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * @return array[]
     */
    public function provideDetectUser()
    {
        return [
            'Matching Membership Number' => [
                [
                    CompassRecord::FIELD_MEMBERSHIP_NUMBER => User::FIELD_MEMBERSHIP_NUMBER,
                ],
                2,
            ],
            'Matching Name' => [
                [
                    CompassRecord::FIELD_FORENAMES => User::FIELD_FIRST_NAME,
                    CompassRecord::FIELD_SURNAME => User::FIELD_LAST_NAME,
                ],
                null,
            ],
            'Matching Email' => [
                [
                    CompassRecord::FIELD_EMAIL => User::FIELD_EMAIL,
                ],
                2,
            ],
            'Matching Email & Name' => [
                [
                    CompassRecord::FIELD_FORENAMES => User::FIELD_FIRST_NAME,
                    CompassRecord::FIELD_SURNAME => User::FIELD_LAST_NAME,
                    CompassRecord::FIELD_EMAIL => User::FIELD_EMAIL,
                ],
                2,
            ],
            'Not Matching' => [
                [],
                null,
            ],
        ];
    }

    /**
     * Test detectUser method
     *
     * @dataProvider provideDetectUser
     * @param array $data Compass Record Fields to be set from User Provided
     * @param int|null $expectedUserId Outcome Expected
     * @return void
     */
    public function testDetectUser(array $data, ?int $expectedUserId): void
    {
        $user = $this->Users->get($expectedUserId ?? 2);

        if (!is_null($expectedUserId)) {
            $expected = $user;
        } else {
            $expected = null;
        }

        $newRecord = $this->CompassRecords->newEntity($this->getGood());

        foreach ($data as $field => $value) {
            $newRecord->set($field, $user->get($value));
        }

        TestCase::assertNotFalse($this->CompassRecords->save($newRecord));

        $actual = $this->CompassRecords->detectUser($newRecord);
        TestCase::assertEquals($expected, $actual);
    }

    public function providePrepareRecord(): array
    {
        return [
            'New Available, Invalid Domain' => [
                'jacob@baddomain.com',
                true,
                false,
            ],
            'New Available, Valid Domain' => [
                'jacob@4thgoat.org.uk',
                true,
                true,
            ],
            'New Unavailable, Invalid Domain' => [
                'jacob@baddomain.com',
                false,
                true,
            ],
            'New Unavailable, Valid Domain' => [
                'jacob@4thgoat.org.uk',
                false,
                true,
            ],
        ];
    }

    /**
     * Test prepareRecord method
     *
     * @dataProvider providePrepareRecord
     * @param string $recordEmail The Email String to be match tested
     * @param bool $available Is a matching Directory user available?
     * @param bool $expected Should the Records match
     * @return void
     */
    public function testPrepareRecord(string $recordEmail, bool $available, bool $expected): void
    {
        $record = $this->CompassRecords->newEntity($this->getGood());
        $record->set(CompassRecord::FIELD_EMAIL, $recordEmail);

        if ($available) {
            $dirUsers = $this->getTableLocator()->get('DirectoryUsers');
            $directoryUser = $dirUsers->get(1);

            $record->set(CompassRecord::FIELD_FORENAMES, $directoryUser->get(DirectoryUser::FIELD_GIVEN_NAME));
            $record->set(CompassRecord::FIELD_SURNAME, $directoryUser->get(DirectoryUser::FIELD_FAMILY_NAME));
        }
        TestCase::assertInstanceOf(CompassRecord::class, $this->CompassRecords->save($record));

        if ($expected) {
            TestCase::assertEquals($record->toArray(), $this->CompassRecords->prepareRecord($record)->toArray());
        } else {
            TestCase::assertNotEquals($record->toArray(), $this->CompassRecords->prepareRecord($record)->toArray());
        }
    }

    /**
     * Test importUser method
     *
     * @return void
     */
    public function testImportUser(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test linkUser method
     *
     * @return void
     */
    public function testLinkUser(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test mapUser method
     *
     * @return void
     */
    public function testMapUser(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    public function provideMergeUser(): array
    {
        return [
            'Good Record Merge' => [
                [],
                [
                    'phone' => true,
                    'email' => true,
                    'group' => true,
                    'deleted' => true,
                ],
            ],
            'Bad Email Merge' => [
                [
                    CompassRecord::FIELD_EMAIL => 'octopus@fish.com',
                ],
                [
                    'phone' => true,
                    'email' => false,
                    'group' => true,
                    'deleted' => false,
                ],
            ],
            'Bad Phone Merge' => [
                [
                    CompassRecord::FIELD_PHONE => 'I like big phone numbers and i cannot lie',
                ],
                [
                    'phone' => false,
                    'email' => true,
                    'group' => true,
                    'deleted' => true,
                ],
            ],
            'Bad Group Merge' => [
                [
                    CompassRecord::FIELD_LOCATION => 'Happy go fishy',
                ],
                [
                    'phone' => false,
                    'email' => true,
                    'group' => false,
                    'deleted' => true,
                ],
            ],
        ];
    }

    /**
     * Test mergeUser method
     *
     * @param array $override Array of Record Values
     * @param array $expected Array of Expectations
     * @return void
     * @dataProvider provideMergeUser
     */
    public function testMergeUser(array $override, array $expected): void
    {
        $record = $this->CompassRecords->newEntity($this->getGood());
        foreach ($override as $field => $value) {
            $record->set($field, $value);
        }
        $record = $this->CompassRecords->save($record);
        TestCase::assertInstanceOf(CompassRecord::class, $record);

        if (!$expected['group']) {
            $this->expectException('Cake\Datasource\Exception\RecordNotFoundException');
        }

        $user = $this->Users->get(2);
        $this->CompassRecords->mergeUser($record, $user);

        $exists = $this->Users->UserContacts->exists([
            UserContact::FIELD_USER_ID => $user->id,
            UserContact::FIELD_USER_CONTACT_TYPE_ID => 2,
            UserContact::FIELD_CONTACT_FIELD => $record->phone,
        ]);
        TestCase::assertEquals($expected['phone'], $exists);

        $exists = $this->Users->UserContacts->exists([
            UserContact::FIELD_USER_ID => $user->id,
            UserContact::FIELD_USER_CONTACT_TYPE_ID => 1,
            UserContact::FIELD_CONTACT_FIELD => $record->email,
        ]);
        TestCase::assertEquals($expected['email'], $exists);

        $exists = $this->CompassRecords->exists([
            CompassRecord::FIELD_MEMBERSHIP_NUMBER => $record->membership_number,
            CompassRecord::FIELD_EMAIL => $record->email,
        ]);
        TestCase::assertEquals(!$expected['deleted'], $exists);
    }
}

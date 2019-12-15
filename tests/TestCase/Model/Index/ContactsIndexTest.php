<?php
namespace App\Test\TestCase\Model\Index;

use App\Model\Entity\User;
use App\Model\Index\ContactsIndex;
use App\Model\Table\UsersTable;
use App\Test\TestCase\Model\Table\ModelTestTrait;
use App\Utility\TextSafe;
use Cake\Cache\Cache;
use Cake\ElasticSearch\IndexRegistry;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsersTable Test Case
 */
class ContactsIndexTest extends TestCase
{
    use ModelTestTrait;

    /**
     * Test subject
     *
     * @var \App\Model\Index\ContactsIndex
     */
    public $Contacts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PasswordStates',
        'app.Users',
        'app.CapabilitiesRoleTypes',
        'app.Capabilities',
        'app.ScoutGroups',
        'app.SectionTypes',
        'app.RoleTemplates',
        'app.RoleTypes',
        'app.RoleStatuses',
        'app.Sections',
        'app.Audits',
        'app.UserContactTypes',
        'app.UserContacts',
        'app.Roles',
        'app.CampTypes',
        'app.Camps',
        'app.CampRoleTypes',
        'app.CampRoles',
        'app.Notifications',
        'app.NotificationTypes',
        'app.EmailSends',
        'app.Tokens',
        'app.EmailResponseTypes',
        'app.EmailResponses',
//        'app.Contacts',
//        'app.Emails',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = IndexRegistry::exists('Contacts') ? [] : ['className' => ContactsIndex::class];
        $this->Contacts = IndexRegistry::get('Contacts', $config);

        $now = new Time('2018-12-26 23:22:30');
        Time::setTestNow($now);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Contacts);

        parent::tearDown();
    }

    /**
     * Get Good Set Function
     *
     * @return array
     *
     * @throws
     */
    private function getGood()
    {
        $date = Time::getTestNow();
        $good = [
            User::FIELD_USERNAME => TextSafe::shuffle(10),
            User::FIELD_MEMBERSHIP_NUMBER => random_int(0, 99999) + random_int(0, 99999),
            User::FIELD_FIRST_NAME => 'Jacob',
            User::FIELD_LAST_NAME => 'Tyler',
            User::FIELD_EMAIL => 'my' . random_int(0, 9999) . 'fake' . random_int(0, 9999) . '@4thgoat.org.uk',
            User::FIELD_PASSWORD => 'Not Telling You',
            User::FIELD_ADDRESS_LINE_1 => 'New Landing Cottage',
            User::FIELD_ADDRESS_LINE_2 => '',
            User::FIELD_CITY => 'Helicopter Place',
            User::FIELD_COUNTY => 'Hertfordshire',
            User::FIELD_POSTCODE => 'SG6 KKS',
            User::FIELD_LAST_LOGIN => $date,
            User::FIELD_LAST_LOGIN_IP => '192.168.0.1',
            User::FIELD_CAPABILITIES => [
                'user' => ['LOGIN', 'EDIT_SELF'],
                'section' => [
                    1 => ['EDIT_USER'],
                    3 => ['EDIT_USER'],
                ],
                'group' => [
                    1 => ['EDIT_SECT'],
                ],
            ],
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
        TestCase::markTestIncomplete('ES not functional');
        $get = 1;
        if (is_array($get)) {
            $actual = $this->Contacts->find('all')->where($get)->first()->toArray();
        } else {
            $actual = $this->Contacts->get($get)->toArray();
        }

//        TestCase::assertEquals($expected, $actual);

        $tableCount = $this->Contacts->find('all')->count();
        TestCase::assertEquals(5, $tableCount);
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testReindexUsers()
    {
        TestCase::markTestIncomplete('ES not functional');

        TestCase::assertTrue($this->Contacts->reindexUsers());
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        TestCase::markTestIncomplete('ES not functional');

        $good = $this->getGood();

        $new = $this->Users->newEntity($good);
        TestCase::assertInstanceOf('App\Model\Entity\User', $this->Users->save($new));

        $required = [
            User::FIELD_MEMBERSHIP_NUMBER,
            User::FIELD_FIRST_NAME,
            User::FIELD_LAST_NAME,
            User::FIELD_EMAIL,
            User::FIELD_POSTCODE,
        ];

        $this->validateRequired($required, $this->Users, [$this, 'getGood']);

        $notRequired = [
            User::FIELD_USERNAME,
            User::FIELD_PASSWORD,
            User::FIELD_ADDRESS_LINE_1,
            User::FIELD_ADDRESS_LINE_2,
            User::FIELD_CITY,
            User::FIELD_COUNTY,
            User::FIELD_LAST_LOGIN,
            User::FIELD_LAST_LOGIN_IP,
        ];

        $this->validateNotRequired($notRequired, $this->Users, [$this, 'getGood']);

        $empties = [
            User::FIELD_ADDRESS_LINE_1,
            User::FIELD_ADDRESS_LINE_2,
            User::FIELD_CITY,
            User::FIELD_COUNTY,
            User::FIELD_LAST_LOGIN,
            User::FIELD_LAST_LOGIN_IP,
            User::FIELD_PASSWORD,
            User::FIELD_USERNAME,
        ];

        $this->validateEmpties($empties, $this->Users, [$this, 'getGood']);

        $notEmpties = [
            User::FIELD_FIRST_NAME,
            User::FIELD_LAST_NAME,
            User::FIELD_EMAIL,
            User::FIELD_POSTCODE,
        ];

        $this->validateNotEmpties($notEmpties, $this->Users, [$this, 'getGood']);

        $this->validateNotEmpty(
            User::FIELD_MEMBERSHIP_NUMBER,
            $this->Users,
            [$this, 'getGood'],
            'default',
            'A unique, valid TSA membership number is required.'
        );

        $maxLengths = [
            User::FIELD_USERNAME => 255,
            User::FIELD_FIRST_NAME => 255,
            User::FIELD_LAST_NAME => 255,
            User::FIELD_PASSWORD => 255,
            User::FIELD_ADDRESS_LINE_1 => 255,
            User::FIELD_ADDRESS_LINE_2 => 255,
            User::FIELD_CITY => 255,
            User::FIELD_COUNTY => 255,
            User::FIELD_POSTCODE => 9,
        ];

        $this->validateMaxLengths($maxLengths, $this->Users, [$this, 'getGood']);

        $this->validateEmail(User::FIELD_EMAIL, $this->Users, [$this, 'getGood']);
    }
}

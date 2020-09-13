<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\User;
use App\Model\Table\UsersTable;
use App\Utility\TextSafe;
use Cake\Cache\Cache;
use Cake\I18n\Time;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsersTable Test Case
 */
class UsersTableTest extends TestCase
{
    use ModelTestTrait;

    /**
     * Test subject
     *
     * @var \App\Model\Table\UsersTable
     */
    protected $Users;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.UserStates',
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
        'app.NotificationTypes',
        'app.Notifications',
        'app.EmailSends',
        'app.Tokens',
        'app.EmailResponseTypes',
        'app.EmailResponses',

        'app.DirectoryTypes',
        'app.Directories',
        'app.DirectoryDomains',
        'app.DirectoryUsers',
        'app.DirectoryGroups',
        'app.RoleTypesDirectoryGroups',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Users') ? [] : ['className' => UsersTable::class];
        $this->Users = $this->getTableLocator()->get('Users', $config);

        $now = new Time('2018-12-26 23:22:30');
        Time::setTestNow($now);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Users);

        parent::tearDown();
    }

    /**
     * Get Good Set Function
     *
     * @return array
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
            User::FIELD_ALL_ROLE_COUNT => 1,
            User::FIELD_ACTIVE_ROLE_COUNT => 1,
            User::FIELD_ALL_EMAIL_COUNT => 1,
            User::FIELD_ALL_PHONE_COUNT => 1,
            User::FIELD_RECEIVE_EMAILS => true,
        ];

        return $good;
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize(): void
    {
        $dates = [
            User::FIELD_MODIFIED,
            User::FIELD_CREATED,
            User::FIELD_DELETED,
            User::FIELD_LAST_LOGIN,
        ];

        $expected = [
            User::FIELD_ID => 1,
            User::FIELD_USERNAME => 'Lorem ipsum dolor sit amet',
            User::FIELD_MEMBERSHIP_NUMBER => 1,
            User::FIELD_FIRST_NAME => 'Lorem ipsum dolor sit amet',
            User::FIELD_LAST_NAME => 'Lorem ipsum dolor sit amet',
            User::FIELD_EMAIL => 'fish@4thgoat.org.uk',
            User::FIELD_ADDRESS_LINE_1 => 'Lorem ipsum dolor sit amet',
            User::FIELD_ADDRESS_LINE_2 => 'Lorem ipsum dolor sit amet',
            User::FIELD_CITY => 'Lorem ipsum dolor sit amet',
            User::FIELD_COUNTY => 'Lorem ipsum dolor sit amet',
            User::FIELD_POSTCODE => 'Lorem i',
            User::FIELD_LAST_LOGIN_IP => '192.168.0.1',
            User::FIELD_FULL_NAME => 'Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet',
            User::FIELD_CAPABILITIES => null,
            User::FIELD_USER_STATE_ID => 1,
            User::FIELD_COGNITO_ENABLED => false,
            User::FIELD_ALL_ROLE_COUNT => 1,
            User::FIELD_ACTIVE_ROLE_COUNT => 1,
            User::FIELD_ALL_EMAIL_COUNT => 1,
            User::FIELD_ALL_PHONE_COUNT => 1,
            User::FIELD_RECEIVE_EMAILS => true,
            User::FIELD_VALIDATED_EMAIL_COUNT => 1,
            User::FIELD_VALIDATED_PHONE_COUNT => 1,
            User::FIELD_GROUPS => null,
            User::FIELD_SECTIONS => null,
            User::FIELD_ACTIVATED => true,
            User::FIELD_SEARCH_STRING => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla '
                . 'gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, '
                . 'vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat '
                . 'in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            User::FIELD_TAG_COUNT => 1,
        ];

        $this->validateInitialise($expected, $this->Users, 2, $dates);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
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

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationNew(): void
    {
        $good = $this->getGood();

        $new = $this->Users->newEntity($good);
        TestCase::assertInstanceOf('App\Model\Entity\User', $this->Users->save($new));

        $required = [
            User::FIELD_MEMBERSHIP_NUMBER,
            User::FIELD_FIRST_NAME,
            User::FIELD_LAST_NAME,
            User::FIELD_EMAIL,
        ];

        $this->validateRequired($required, $this->Users, [$this, 'getGood'], 'new');

        $notRequired = [
            User::FIELD_USERNAME,
            User::FIELD_POSTCODE,
            User::FIELD_PASSWORD,
            User::FIELD_ADDRESS_LINE_1,
            User::FIELD_ADDRESS_LINE_2,
            User::FIELD_CITY,
            User::FIELD_COUNTY,
            User::FIELD_LAST_LOGIN,
            User::FIELD_LAST_LOGIN_IP,
        ];

        $this->validateNotRequired($notRequired, $this->Users, [$this, 'getGood'], 'new');

        $empties = [
            User::FIELD_ADDRESS_LINE_1,
            User::FIELD_ADDRESS_LINE_2,
            User::FIELD_CITY,
            User::FIELD_COUNTY,
            User::FIELD_LAST_LOGIN,
            User::FIELD_LAST_LOGIN_IP,
            User::FIELD_PASSWORD,
            User::FIELD_USERNAME,
            User::FIELD_POSTCODE,
        ];

        $this->validateEmpties($empties, $this->Users, [$this, 'getGood'], 'new');

        $notEmpties = [
            User::FIELD_FIRST_NAME,
            User::FIELD_LAST_NAME,
            User::FIELD_EMAIL,
        ];

        $this->validateNotEmpties($notEmpties, $this->Users, [$this, 'getGood'], 'new');

        $this->validateNotEmpty(
            User::FIELD_MEMBERSHIP_NUMBER,
            $this->Users,
            [$this, 'getGood'],
            'default',
            'A unique, valid TSA membership number is required.'
        );

        $maxLengths = [
            User::FIELD_FIRST_NAME => 255,
            User::FIELD_LAST_NAME => 255,
        ];

        $this->validateMaxLengths($maxLengths, $this->Users, [$this, 'getGood'], 'new');

        $this->validateEmail(User::FIELD_EMAIL, $this->Users, [$this, 'getGood'], 'new');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        // Is Unique
        $uniques = [
            User::FIELD_USERNAME,
            User::FIELD_MEMBERSHIP_NUMBER,
            User::FIELD_EMAIL,
        ];
        $this->validateUniqueRules($uniques, $this->Users, [$this, 'getGood']);

        $this->validateExistsRule(User::FIELD_USER_STATE_ID, $this->Users, $this->Users->UserStates, [$this, 'getGood']);
    }

    /**
     * Test Password Hashing method
     *
     * @return void
     */
    public function testPasswordHashing(): void
    {
        $good = $this->getGood();

        $new = $this->Users->newEntity($good);
        TestCase::assertInstanceOf($this->Users->getEntityClass(), $this->Users->save($new));

        TestCase::assertNotEquals($good[User::FIELD_PASSWORD], $new->password);
    }

    /**
     * @param array $expected Array of Expected Capabilities
     * @param array $actual Actual Array
     */
    private function validateCapabilityArray($expected, $actual): void
    {
        if (key_exists('user', $expected)) {
            TestCase::assertArrayHasKey('user', $actual);
            TestCase::assertEquals(count($expected['user']), count($actual['user']));

            foreach ($expected['user'] as $value) {
                TestCase::assertTrue(in_array($value, $actual['user']));
            }
        }

        if (key_exists('group', $expected)) {
            TestCase::assertArrayHasKey('group', $actual);
            TestCase::assertEquals(count($expected['group']), count($actual['group']));

            foreach ($expected['group'] as $idx => $value) {
                TestCase::assertTrue(in_array($value, $actual['group']));
                TestCase::assertEquals(count($expected['group'][$idx]), count($actual['group'][$idx]));

                foreach ($expected['group'][$idx] as $innerValue) {
                    TestCase::assertTrue(in_array($innerValue, $actual['group'][$idx]));
                }
            }
        }

        if (key_exists('section', $expected)) {
            TestCase::assertArrayHasKey('section', $actual);

            TestCase::assertEquals(count($expected['section']), count($actual['section']));

            foreach ($expected['section'] as $idx => $value) {
                TestCase::assertTrue(in_array($value, $actual['section']));
                TestCase::assertEquals(count($expected['section'][$idx]), count($actual['section'][$idx]));

                foreach ($expected['section'][$idx] as $innerValue) {
                    TestCase::assertTrue(in_array($innerValue, $actual['section'][$idx]));
                }
            }
        }
    }

    /**
     * Test retrieveCapabilities method
     *
     * @return void
     */
    public function testRetrieveAllCapabilities(): void
    {
        $user = $this->Users->get(1);
        $capabilities = $this->Users->retrieveAllCapabilities($user);

        $expected = [
            'user' => [
                (int)6 => 'ALL',
                (int)4 => 'EDIT_GROUP',
                (int)1 => 'LOGIN',
                (int)0 => 'OWN_USER',
            ],
            'group' => [
                (int)1 => [
                    (int)0 => 'EDIT_SECT',
                ],
            ],
            'section' => [
                (int)1 => [
                    (int)0 => 'EDIT_USER',
                ],
            ],
        ];

        $this->validateCapabilityArray($expected, $capabilities);

        $user = $this->Users->get(2);
        $capabilities = $this->Users->retrieveAllCapabilities($user);

        $expected = [
            'user' => [
                (int)0 => 'LOGIN',
            ],
            'group' => [
                (int)1 => [
                    (int)0 => 'EDIT_SECT',
                ],
            ],
            'section' => [
                (int)2 => [
                    (int)0 => 'EDIT_USER',
                ],
                (int)1 => [
                    (int)0 => 'EDIT_USER',
                ],
            ],
        ];

        $this->validateCapabilityArray($expected, $capabilities);
    }

    /**
     * Test retrieveCapabilities method
     *
     * @return void
     */
    public function testRetrieveCapabilities(): void
    {
        Cache::clear('capability');
        $user = $this->Users->get(1);
        $capabilities = $this->Users->retrieveCapabilities($user);

        $expected = [
            'user' => [
                (int)6 => 'ALL',
                (int)4 => 'EDIT_GROUP',
                (int)1 => 'LOGIN',
                (int)0 => 'OWN_USER',
            ],
            'group' => [
                (int)1 => [
                    (int)0 => 'EDIT_SECT',
                ],
            ],
            'section' => [
                (int)1 => [
                    (int)0 => 'EDIT_USER',
                ],
            ],
        ];

        $this->validateCapabilityArray($expected, $capabilities);

        $user = $this->Users->get(2);
        $capabilities = $this->Users->retrieveCapabilities($user);

        $expected = [
            'user' => [
                (int)0 => 'LOGIN',
            ],
            'group' => [
                (int)1 => [
                    (int)0 => 'EDIT_SECT',
                ],
            ],
            'section' => [
                (int)2 => [
                    (int)0 => 'EDIT_USER',
                ],
                (int)1 => [
                    (int)0 => 'EDIT_USER',
                ],
            ],
        ];

        $this->validateCapabilityArray($expected, $capabilities);
    }

    /**
     * Test userCapability method
     *
     * @return void
     */
    public function testUserCapability(): void
    {
        Cache::clear('capability');

        // Basic Assert Positive
        $user = $this->Users->get(1);
        $cap = 'OWN_USER';

        $result = $this->Users->userCapability($user, $cap);
        TestCase::assertTrue($result);

        // Basic Assert Negative
        $user = $this->Users->get(2);
        $cap = 'OWN_USER';

        $result = $this->Users->userCapability($user, $cap);
        TestCase::assertFalse($result);

        // Sections
        $user = $this->Users->get(2);
        $cap = 'EDIT_USER';

        $result = $this->Users->userCapability($user, $cap);
        TestCase::assertArrayHasKey('sections', $result);
        TestCase::assertArrayHasKey('groups', $result);

        $expected = [ 1, 2, ];
        foreach ($expected as $value) {
            TestCase::assertTrue(in_array($value, $result['sections']));
        }

        TestCase::assertEquals(count($expected), count($result['sections']));

        // Groups
        $user = $this->Users->get(2);
        $cap = 'EDIT_SECT';

        $result = $this->Users->userCapability($user, $cap);
        TestCase::assertArrayHasKey('groups', $result);

        $expected = [
            'sections' => [],
            'groups' => [ 1 ],
        ];
        TestCase::assertEquals($expected, $result);
    }

    /**
     * Test FindAuth Method
     *
     * @return void
     */
    public function testFindAuth(): void
    {
        $allQuery = $this->Users->find('all');
        $authQuery = $this->Users->find('auth');

        TestCase::assertNotEquals($allQuery, $authQuery);
    }

    /**
     * Test Patch Capabilities Method
     *
     * @return void
     */
    public function testPatchCapabilities(): void
    {
        $user = $this->Users->get(1);
        TestCase::assertNull($user->capabilities);

        $this->Users->patchCapabilities($user);

        $user = $this->Users->get(1);
        TestCase::assertNotNull($user->capabilities);

        $expected = [
            'user' => [
                'OWN_USER',
                'LOGIN',
                6 => 'ALL',
                4 => 'EDIT_GROUP',
            ],
            'section' => [
                1 => [
                    'EDIT_USER',
                ],
            ],
            'group' => [
                1 => [
                    'EDIT_SECT',
                ],
            ],
        ];
        $this->validateCapabilityArray($expected, $user->capabilities);
    }

    /**
     * Test case for IsValidDomainEmail method
     *
     * @return void
     */
    public function testIsValidDomainEmail(): void
    {
        TestCase::assertFalse($this->Users->isValidDomainEmail('cheese@buttons.com', []));

        TestCase::assertTrue($this->Users->isValidDomainEmail('jacob@4thgoat.org.uk', []));
    }
}

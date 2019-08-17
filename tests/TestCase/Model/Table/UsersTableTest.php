<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UsersTable;
use Cake\Cache\Cache;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\Utility\Security;

/**
 * App\Model\Table\UsersTable Test Case
 */
class UsersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\UsersTable
     */
    public $Users;

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
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Users') ? [] : ['className' => UsersTable::class];
        $this->Users = TableRegistry::getTableLocator()->get('Users', $config);

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
        unset($this->Users);

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
            'username' => 'Jacob' . random_int(0, 999) . random_int(0, 999),
            'membership_number' => random_int(0, 99999) + random_int(0, 99999),
            'first_name' => 'Jacob',
            'last_name' => 'Tyler',
            'email' => 'myfake' . random_int(0, 9999) . '@email' . random_int(0, 9999) . '.com',
            'password' => 'Not Telling You',
            'address_line_1' => 'New Landing Cottage',
            'address_line_2' => '',
            'city' => 'Helicopter Place',
            'county' => 'Hertfordshire',
            'postcode' => 'SG6 KKS',
            'admin_scout_group_id' => 1,
            'last_login' => $date,
            'last_login_ip' => '192.168.0.1',
            'capabilities' => [
                'user' => [
                    'LOGIN',
                    'EDIT_SELF'
                ],
                'section' => [
                    1 => [
                        'EDIT_USER'
                    ],
                    3 => [
                        'EDIT_USER'
                    ]
                ],
                'group' => [
                    1 => [
                        'EDIT_SECT'
                    ]
                ]
            ]
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
        $actual = $this->Users->get(1)->toArray();

        $dates = [
            'modified',
            'created',
            'deleted',
            'last_login',
        ];

        foreach ($dates as $date) {
            $dateValue = $actual[$date];
            if (!is_null($dateValue)) {
                TestCase::assertInstanceOf('Cake\I18n\FrozenTime', $dateValue);
            }
            unset($actual[$date]);
        }

        $expected = [
            'id' => 1,
            'username' => 'Lorem ipsum dolor sit amet',
            'membership_number' => 1,
            'first_name' => 'Lorem ipsum dolor sit amet',
            'last_name' => 'Lorem ipsum dolor sit amet',
            'email' => 'Lorem ipsum dolor sit amet',
            'address_line_1' => 'Lorem ipsum dolor sit amet',
            'address_line_2' => 'Lorem ipsum dolor sit amet',
            'city' => 'Lorem ipsum dolor sit amet',
            'county' => 'Lorem ipsum dolor sit amet',
            'postcode' => 'Lorem i',
            'last_login_ip' => '192.168.0.1',
            'full_name' => 'Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet',
            'capabilities' => null,
            'password_state_id' => 1,
        ];
        TestCase::assertEquals($expected, $actual);

        $count = $this->Users->find('all')->count();
        TestCase::assertEquals(2, $count);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $good = $this->getGood();

        $new = $this->Users->newEntity($good);
        TestCase::assertInstanceOf('App\Model\Entity\User', $this->Users->save($new));

        $required = [
            'membership_number',
            'first_name',
            'last_name',
            'email',
        ];

        foreach ($required as $require) {
            $reqArray = $this->getGood();
            unset($reqArray[$require]);
            $new = $this->Users->newEntity($reqArray);
            TestCase::assertFalse($this->Users->save($new));
        }

        $notRequired = [
            'username',
            'password',
            'address_line_1',
            'address_line_2',
            'city',
            'county',
            'postcode',
            'last_login',
            'last_login_ip',
        ];

        foreach ($notRequired as $not_required) {
            $reqArray = $this->getGood();
            unset($reqArray[$not_required]);
            $new = $this->Users->newEntity($reqArray);
            TestCase::assertInstanceOf('App\Model\Entity\User', $this->Users->save($new));
        }

        $empties = [
            'address_line_1',
            'address_line_2',
            'city',
            'county',
            'postcode',
            'last_login',
            'last_login_ip',
            'password',
            'username',
        ];

        foreach ($empties as $empty) {
            $reqArray = $this->getGood();
            $reqArray[$empty] = '';
            $new = $this->Users->newEntity($reqArray);
            TestCase::assertInstanceOf('App\Model\Entity\User', $this->Users->save($new));
        }

        $notEmpties = [
            'membership_number',
            'first_name',
            'last_name',
            'email',
        ];

        foreach ($notEmpties as $not_empty) {
            $reqArray = $this->getGood();
            $reqArray[$not_empty] = '';
            $new = $this->Users->newEntity($reqArray);
            TestCase::assertFalse($this->Users->save($new));
        }

        $maxLengths = [
            'username' => 255,
            'first_name' => 255,
            'last_name' => 255,
            'password' => 255,
            'address_line_1' => 255,
            'address_line_2' => 255,
            'city' => 255,
            'county' => 255,
            'postcode' => 9,
        ];

        $string = hash('sha512', Security::randomBytes(64));
        $string .= $string;
        $string .= $string;

        foreach ($maxLengths as $maxField => $max_length) {
            $reqArray = $this->getGood();
            $reqArray[$maxField] = substr($string, 1, $max_length);
            $new = $this->Users->newEntity($reqArray);
            TestCase::assertInstanceOf('App\Model\Entity\User', $this->Users->save($new));

            $reqArray = $this->getGood();
            $reqArray[$maxField] = substr($string, 1, $max_length + 1);
            $new = $this->Users->newEntity($reqArray);
            TestCase::assertFalse($this->Users->save($new));
        }
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        // Is Unique
        $uniques = [
            'username' => 'JacobNew',
            'membership_number' => 210210210,
            'email' => 'my@unique.email',
        ];

        foreach ($uniques as $unqueField => $uniqueValue) {
            $values = $this->getGood();

            $existing = $this->Users->get(1)->toArray();

            $values[$unqueField] = $uniqueValue;
            $new = $this->Users->newEntity($values);
            TestCase::assertInstanceOf('App\Model\Entity\User', $this->Users->save($new));

            $values = $this->getGood();

            $values[$unqueField] = $existing[$unqueField];
            $new = $this->Users->newEntity($values);
            TestCase::assertFalse($this->Users->save($new));
        }
    }

    /**
     * Test Password Hashing method
     *
     * @return void
     */
    public function testPasswordHashing()
    {
        $good = $this->getGood();

        $new = $this->Users->newEntity($good);
        TestCase::assertInstanceOf('App\Model\Entity\User', $this->Users->save($new));

        TestCase::assertNotEquals($good['password'], $new->password);
    }

    /**
     * @param array $expected Array of Expected Capabilities
     * @param array $actual Actual Array
     */
    private function validateCapabilityArray($expected, $actual)
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
    public function testRetrieveAllCapabilities()
    {
        $user = $this->Users->get(1);
        $capabilities = $this->Users->retrieveAllCapabilities($user);

        $expected = [
            'user' => [
                (int)6 => 'ALL',
                (int)4 => 'EDIT_GROUP',
                (int)1 => 'LOGIN',
                (int)0 => 'OWN_USER'
            ],
            'group' => [
                (int)1 => [
                    (int)0 => 'EDIT_SECT'
                ]
            ],
            'section' => [
                (int)1 => [
                    (int)0 => 'EDIT_USER'
                ]
            ]
        ];

        $this->validateCapabilityArray($expected, $capabilities);

        $user = $this->Users->get(2);
        $capabilities = $this->Users->retrieveAllCapabilities($user);

        $expected = [
            'user' => [
                (int)0 => 'LOGIN'
            ],
            'group' => [
                (int)1 => [
                    (int)0 => 'EDIT_SECT'
                ]
            ],
            'section' => [
                (int)2 => [
                    (int)0 => 'EDIT_USER'
                ],
                (int)1 => [
                    (int)0 => 'EDIT_USER'
                ]
            ]
        ];

        $this->validateCapabilityArray($expected, $capabilities);
    }

    /**
     * Test retrieveCapabilities method
     *
     * @return void
     */
    public function testRetrieveCapabilities()
    {
        Cache::clear(false, 'capability');
        $user = $this->Users->get(1);
        $capabilities = $this->Users->retrieveCapabilities($user);

        $expected = [
            'user' => [
                (int)6 => 'ALL',
                (int)4 => 'EDIT_GROUP',
                (int)1 => 'LOGIN',
                (int)0 => 'OWN_USER'
            ],
            'group' => [
                (int)1 => [
                    (int)0 => 'EDIT_SECT'
                ]
            ],
            'section' => [
                (int)1 => [
                    (int)0 => 'EDIT_USER'
                ]
            ]
        ];

        $this->validateCapabilityArray($expected, $capabilities);

        $user = $this->Users->get(2);
        $capabilities = $this->Users->retrieveCapabilities($user);

        $expected = [
            'user' => [
                (int)0 => 'LOGIN'
            ],
            'group' => [
                (int)1 => [
                    (int)0 => 'EDIT_SECT'
                ]
            ],
            'section' => [
                (int)2 => [
                    (int)0 => 'EDIT_USER'
                ],
                (int)1 => [
                    (int)0 => 'EDIT_USER'
                ]
            ]
        ];

        $this->validateCapabilityArray($expected, $capabilities);
    }

    /**
     * Test userCapability method
     *
     * @return void
     */
    public function testUserCapability()
    {
        Cache::clear(false, 'capability');

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
            'groups' => [ 1 ]
        ];
        TestCase::assertEquals($expected, $result);
    }

    /**
     * Test FindAuth Method
     *
     * @return void
     */
    public function testFindAuth()
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
    public function testPatchCapabilities()
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
                    'EDIT_USER'
                ],
            ],
            'group' => [
                1 => [
                    'EDIT_SECT'
                ]
            ]
        ];
        $this->validateCapabilityArray($expected, $user->capabilities);
    }
}

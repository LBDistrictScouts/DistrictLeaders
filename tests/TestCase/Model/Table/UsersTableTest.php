<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UsersTable;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\Utility\Security;
use mysql_xdevapi\Exception;

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
        'app.Users',
        'app.RoleTypes',
        'app.RoleStatuses',
        'app.Sections',
        'app.SectionTypes',
        'app.ScoutGroups',
        'app.Audits',
        'app.Roles',
        'app.Capabilities',
        'app.CapabilitiesRoleTypes',
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
                $this->assertInstanceOf('Cake\I18n\FrozenTime', $dateValue);
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
            'admin_scout_group_id' => 1,
            'last_login_ip' => '192.168.0.1',
            'full_name' => 'Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet',
            'capabilities' => [
                'LOGIN'
            ],
        ];
        $this->assertEquals($expected, $actual);

        $count = $this->Users->find('all')->count();
        $this->assertEquals(2, $count);
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
        $this->assertInstanceOf('App\Model\Entity\User', $this->Users->save($new));

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
            $this->assertFalse($this->Users->save($new));
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
            $this->assertInstanceOf('App\Model\Entity\User', $this->Users->save($new));
        }

        $empties = [
            'address_line_1',
            'address_line_2',
            'city',
            'county',
            'postcode',
            'last_login',
            'last_login_ip',
        ];

        foreach ($empties as $empty) {
            $reqArray = $this->getGood();
            $reqArray[$empty] = '';
            $new = $this->Users->newEntity($reqArray);
            $this->assertInstanceOf('App\Model\Entity\User', $this->Users->save($new));
        }

        $notEmpties = [
            'username',
            'membership_number',
            'first_name',
            'last_name',
            'email',
            'password',
        ];

        foreach ($notEmpties as $not_empty) {
            $reqArray = $this->getGood();
            $reqArray[$not_empty] = '';
            $new = $this->Users->newEntity($reqArray);
            $this->assertFalse($this->Users->save($new));
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
            $this->assertInstanceOf('App\Model\Entity\User', $this->Users->save($new));

            $reqArray = $this->getGood();
            $reqArray[$maxField] = substr($string, 1, $max_length + 1);
            $new = $this->Users->newEntity($reqArray);
            $this->assertFalse($this->Users->save($new));
        }
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        // Admin Group Exists
        $values = $this->getGood();

        $groups = $this->Users->ScoutGroups->find('list')->toArray();

        $group = max(array_keys($groups));

        $values['user_id'] = $group;
        $new = $this->Users->newEntity($values);
        $this->assertInstanceOf('App\Model\Entity\User', $this->Users->save($new));

        $values['user_id'] = $group + 1;
        $new = $this->Users->newEntity($values);
        $this->assertFalse($this->Users->save($new));

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
            $this->assertInstanceOf('App\Model\Entity\User', $this->Users->save($new));

            $values = $this->getGood();

            $values[$unqueField] = $existing[$unqueField];
            $new = $this->Users->newEntity($values);
            $this->assertFalse($this->Users->save($new));
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
        $this->assertInstanceOf('App\Model\Entity\User', $this->Users->save($new));

        $this->assertNotEquals($good['password'], $new->password);
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

        $this->assertEquals($expected, $capabilities);

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

        $this->assertEquals($expected, $capabilities);
    }

    /**
     * Test retrieveCapabilities method
     *
     * @return void
     */
    public function testRetrieveCapabilities()
    {
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

        $this->assertEquals($expected, $capabilities);

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

        $this->assertEquals($expected, $capabilities);
    }

    /**
     * Test userCapability method
     *
     * @return void
     */
    public function testUserCapability()
    {
        // Basic Assert Positive
        $user = $this->Users->get(1);
        $cap = 'OWN_USER';

        $result = $this->Users->userCapability($user, $cap);
        $this->assertTrue($result);

        // Basic Assert Negative
        $user = $this->Users->get(2);
        $cap = 'OWN_USER';

        $result = $this->Users->userCapability($user, $cap);
        $this->assertFalse($result);

        // Sections
        $user = $this->Users->get(2);
        $cap = 'EDIT_USER';

        $result = $this->Users->userCapability($user, $cap);
        $this->assertArrayHasKey('sections', $result);

        $expected = [
            'sections' => [
                (int)0 => (int)2,
                (int)1 => (int)1
            ],
            'groups' => []
        ];
        $this->assertEquals($expected, $result);

        // Groups
        $user = $this->Users->get(2);
        $cap = 'EDIT_SECT';

        $result = $this->Users->userCapability($user, $cap);
        $this->assertArrayHasKey('groups', $result);

        $expected = [
            'sections' => [],
            'groups' => [
                (int)0 => (int)1
            ]
        ];
        $this->assertEquals($expected, $result);
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

        $this->assertNotEquals($allQuery, $authQuery);
    }
}

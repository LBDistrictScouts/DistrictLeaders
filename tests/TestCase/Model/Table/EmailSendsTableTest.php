<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmailSendsTable;
use Cake\I18n\FrozenTime;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmailSendsTable Test Case
 */
class EmailSendsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EmailSendsTable
     */
    public $EmailSends;

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
        $config = TableRegistry::getTableLocator()->exists('EmailSends') ? [] : ['className' => EmailSendsTable::class];
        $this->EmailSends = TableRegistry::getTableLocator()->get('EmailSends', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EmailSends);

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
        $now = FrozenTime::getTestNow();
        $good = [
            'sent' => $now,
            'message_send_code' => 'PSJs' . random_int(111, 999) . 'sxa928as' . random_int(111, 999) . 'SMZX9',
            'user_id' => 1,
            'subject' => 'Lorem ipsum dolor sit amet',
            'routing_domain' => 'Lorem ipsum dolor sit amet',
            'from_address' => 'Lorem ipsum dolor sit amet',
            'friendly_from' => 'Lorem ipsum dolor sit amet',
            'notification_type_id' => 1,
            'notification_id' => 1,
            'deleted' => null,
            'email_generation_code' => 'RSV-' . random_int(111, 999) . '-' . random_int(1, 9) . 'DR',
            'email_template' => 'reservation',
            'include_token' => true,
        ];

        return $good;
    }

    /**
     * Get Expected Function
     *
     * @return array
     *
     * @throws
     */
    private function getExpected()
    {
        return [
            'id' => 2,
            'message_send_code' => null,
            'user_id' => 2,
            'subject' => 'Welcome to Site Llama Fish',
            'routing_domain' => null,
            'from_address' => null,
            'friendly_from' => null,
            'notification_id' => 2,
            'email_generation_code' => 'USR-2-NEW',
            'email_template' => 'new_user',
            'include_token' => true,
            'tokens' => [
                [
                    'id' => 2,
                    'email_send_id' => 2,
                    'utilised' => null,
                    'active' => true,
                    'token_header' => [
                        'redirect' => [
                            'action' => 'token',
                            'prefix' => false,
                            'controller' => 'Users',
                        ],
                        'authenticate' => true,
                    ],
                ]
            ],
            'notification' => [
                'notification_header' => 'Welcome to Site Llama Fish',
                'id' => 2,
                'user_id' => 2,
                'notification_type_id' => 2,
                'new' => true,
                'text' => null,
                'read_date' => null,
                'notification_source' => 'User',
                'link_id' => null,
                'link_controller' => null,
                'link_prefix' => false,
                'link_action' => null,
            ],
        ];
    }

    /**
     * Test initialize method
     *
     * @return void
     *
     * @throws \Exception
     */
    public function testInitialize()
    {
        $actual = $this->EmailSends->get(1)->toArray();

        $dates = [
            'sent',
            'created',
            'modified',
            'deleted',
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
            'message_send_code' => 'PSJs821sxa928as219SMZX9',
            'user_id' => 1,
            'subject' => 'Lorem ipsum dolor sit amet',
            'routing_domain' => 'Lorem ipsum dolor sit amet',
            'from_address' => 'Lorem ipsum dolor sit amet',
            'friendly_from' => 'Lorem ipsum dolor sit amet',
            'notification_id' => 1,
            'email_generation_code' => 'RSV-2-5DR',
            'email_template' => 'reservation',
            'include_token' => true,
        ];
        TestCase::assertEquals($expected, $actual);

        $count = $this->EmailSends->find('all')->count();
        TestCase::assertEquals(1, $count);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     *
     * @throws
     */
    public function testValidationDefault()
    {
        $good = $this->getGood();

        $new = $this->EmailSends->newEntity($good);
        TestCase::assertInstanceOf('App\Model\Entity\EmailSend', $this->EmailSends->save($new));

        $empties = [
            'sent',
            'message_send_code',
            'user_id',
            'subject',
            'routing_domain',
            'from_address',
            'friendly_from',
            'notification_type_id',
            'notification_id',
        ];

        foreach ($empties as $empty) {
            $reqArray = $this->getGood();
            $reqArray[$empty] = '';
            $new = $this->EmailSends->newEntity($reqArray);
            TestCase::assertInstanceOf('App\Model\Entity\EmailSend', $this->EmailSends->save($new));
        }
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        // Notification Exists
        $values = $this->getGood();

        $notifications = $this->EmailSends->Notifications->find('list')->toArray();

        $notification = max(array_keys($notifications));

        $values['notification_id'] = $notification;
        $new = $this->EmailSends->newEntity($values);
        TestCase::assertInstanceOf('App\Model\Entity\EmailSend', $this->EmailSends->save($new));

        $values['notification_id'] = $notification + 1;
        $new = $this->EmailSends->newEntity($values);
        TestCase::assertFalse($this->EmailSends->save($new));

        // Users Exist
        $values = $this->getGood();

        $users = $this->EmailSends->Users->find('list')->toArray();

        $user = max(array_keys($users));

        $values['user_id'] = $user;
        $new = $this->EmailSends->newEntity($values);
        TestCase::assertInstanceOf('App\Model\Entity\EmailSend', $this->EmailSends->save($new));

        $values['user_id'] = $user + 1;
        $new = $this->EmailSends->newEntity($values);
        TestCase::assertFalse($this->EmailSends->save($new));
    }

    /**
     * Test Make method
     *
     * @return void
     *
     * @throws
     */
    public function testMake()
    {
        $makeArray = [
            'USR-2-NEW' => 2,
        ];

        foreach ($makeArray as $genCode => $expId) {
            $result = $this->EmailSends->make($genCode);
            TestCase::assertEquals($expId, $result);

            // Check second is blocked.
            TestCase::assertFalse($this->EmailSends->make($genCode));
        }

        $expected = $this->getExpected();

        $actual = $this->EmailSends->get(2, [
            'contain' => [
                'Notifications',
                'Tokens'
            ]])->toArray();

        $dates = [
            'sent',
            'created',
            'modified',
            'deleted',
            'expires',
        ];

        foreach ($dates as $date) {
            unset($actual[$date]);
            unset($actual['tokens'][0][$date]);
            unset($actual['notification'][$date]);
        }
        unset($actual['tokens'][0]['random_number']);

        TestCase::assertEquals($expected, $actual);

        $exemptMakeArray = [
            'USR-2-PWD' => 3,
        ];

        foreach ($exemptMakeArray as $genCode => $expId) {
            $result = $this->EmailSends->make($genCode);
            TestCase::assertEquals($expId, $result);

            // Check second is not blocked.
            TestCase::assertEquals($expId + 1, $this->EmailSends->make($genCode));

            // Check third is not blocked
            TestCase::assertEquals($expId + 2, $this->EmailSends->make($genCode));
        }
    }
}

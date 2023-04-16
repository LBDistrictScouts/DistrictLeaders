<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\EmailSend;
use App\Model\Entity\Notification;
use App\Model\Table\EmailSendsTable;
use App\Test\TestCase\EmailTestCase as TestCase;
use Cake\I18n\FrozenTime;

/**
 * App\Model\Table\EmailSendsTable Test Case
 */
class EmailSendsTableTest extends TestCase
{
    use ModelTestTrait;

    /**
     * Test subject
     *
     * @var EmailSendsTable
     */
    public $EmailSends;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('EmailSends') ? [] : ['className' => EmailSendsTable::class];
        $this->EmailSends = $this->getTableLocator()->get('EmailSends', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->EmailSends);

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
     * @param string $type Notification Type, Type Code
     * @param int $sendId Expected Send Code ID
     * @param int $notificationId Expected Notification ID
     * @return array
     */
    private function getExpected(string $type, int $sendId, int $notificationId): array
    {
        $typeArray = [
            'NEW' => [
                'subject' => 'Welcome to Site',
                'type_id' => 2,
                'action' => 'welcome',
            ],
            'PWD' => [
                'subject' => 'Password Reset for',
                'type_id' => 3,
                'action' => 'password',
            ],
        ];

        return [
            'id' => $sendId,
            'message_send_code' => null,
            'user_id' => 2,
            'subject' => $typeArray[$type]['subject'] . ' Llama Fish',
            'routing_domain' => null,
            'from_address' => null,
            'friendly_from' => null,
            'notification_id' => $notificationId,
            'email_generation_code' => 'USR-2-' . $type,
            'email_template' => $typeArray[$type]['action'],
            'include_token' => true,
            'tokens' => [
                [
                    'id' => $sendId - 1,
                    'email_send_id' => $sendId,
                    'utilised' => null,
                    'active' => true,
                    'token_header' => [
                        'redirect' => [
                            'action' => $typeArray[$type]['action'],
                            'controller' => 'Users',
                        ],
                        'authenticate' => true,
                    ],
                ],
            ],
            'notification' => [
                Notification::FIELD_NOTIFICATION_HEADER => $typeArray[$type]['subject'] . ' Llama Fish',
                Notification::FIELD_ID => $notificationId,
                Notification::FIELD_USER_ID => 2,
                Notification::FIELD_NOTIFICATION_TYPE_ID => $typeArray[$type]['type_id'],
                Notification::FIELD_READ_DATE => null,
                Notification::FIELD_NOTIFICATION_SOURCE => 'USR-2-' . $type,
                Notification::FIELD_BODY_CONTENT => [],
                Notification::FIELD_SUBJECT_LINK => [
                    'controller' => 'Users',
                    'action' => $typeArray[$type]['action'],
                ],
                Notification::FIELD_EMAIL_CODE => null,
            ],
        ];
    }

    private function validateExpected(string $type, int $sendId, int $notificationId): void
    {
        $expected = $this->getExpected($type, $sendId, $notificationId);
        $actual = $this->EmailSends->get($sendId, [
            'contain' => [
                'Notifications',
                'Tokens',
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
    }

    /**
     * Test initialize method
     *
     * @return void
     * @throws Exception
     */
    public function testInitialize()
    {
        $dates = [
            'sent',
            'created',
            'modified',
            'deleted',
        ];

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

        $this->validateInitialise($expected, $this->EmailSends, 2, $dates);
    }

    /**
     * Test validationDefault method
     *
     * @return void
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
        $this->validateEmpties($empties, $this->EmailSends, [$this, 'getGood']);
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $exists = [
            EmailSend::FIELD_NOTIFICATION_ID => $this->EmailSends->Notifications,
            EmailSend::FIELD_USER_ID => $this->EmailSends->Users,
        ];
        $this->validateExistsRules($exists, $this->EmailSends, [$this, 'getGood']);
    }

    public function provideMake(): array
    {
        return [
            'Welcome New User (non-repetitive)' => [
                'USR-2-NEW',
                'NEW',
                true,
            ],
            'Password Reset (repetitive)' => [
                'USR-2-PWD',
                'PWD',
                false,
            ],
        ];
    }

    /**
     * Test Make method
     *
     * @param string $emailGenerationCode Email Generation Code for Testing
     * @param string $type The Email Generation Code Type
     * @param bool $expectedToIterate Expect Notification ID to iterate or stick
     * @return void
     * @dataProvider provideMake
     */
    public function testMake(string $emailGenerationCode, string $type, bool $expectedToIterate): void
    {
        $result = $this->EmailSends->make($emailGenerationCode);
        $sendId = 3;
        $notificationId = 2;

        TestCase::assertEquals($notificationId, $result->notification_id);
        $this->validateExpected($type, $sendId, $notificationId);

        // Check second is not blocked.
        $sendId++;
        if (!$expectedToIterate) {
            $notificationId++;
        }
        TestCase::assertEquals($notificationId, $this->EmailSends->make($emailGenerationCode)->notification_id);
//        $this->validateExpected($type, $sendId, $notificationId); removed array check

        $sendId++;
        if (!$expectedToIterate) {
            $notificationId++;
        }
        // Check third is not blocked
        TestCase::assertEquals($notificationId, $this->EmailSends->make($emailGenerationCode)->notification_id);
        $this->validateExpected($type, $sendId, $notificationId);
    }
}

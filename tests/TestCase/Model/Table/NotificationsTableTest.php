<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\Notification;
use App\Model\Table\NotificationsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NotificationsTable Test Case
 */
class NotificationsTableTest extends TestCase
{
    use ModelTestTrait;

    /**
     * Test subject
     *
     * @var \App\Model\Table\NotificationsTable
     */
    protected $Notifications;

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
        'app.Sections',

        'app.RoleTemplates',
        'app.RoleTypes',
        'app.RoleStatuses',

        'app.Audits',
        'app.UserContactTypes',
        'app.UserContacts',

        'app.DirectoryTypes',
        'app.Directories',
        'app.DirectoryDomains',
        'app.DirectoryUsers',
        'app.DirectoryGroups',
        'app.RoleTypesDirectoryGroups',

        'app.Roles',

        'app.NotificationTypes',
        'app.Notifications',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Notifications') ? [] : ['className' => NotificationsTable::class];
        $this->Notifications = $this->getTableLocator()->get('Notifications', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Notifications);

        parent::tearDown();
    }

    /**
     * @return array
     */
    public function getGood(): array
    {
        return [
            Notification::FIELD_USER_ID => 1,
            Notification::FIELD_NOTIFICATION_TYPE_ID => 1,
            Notification::FIELD_NOTIFICATION_HEADER => 'A payment has been recorded.',
            Notification::FIELD_NOTIFICATION_SOURCE => 'System Generated',
            Notification::FIELD_BODY_CONTENT => ['Chocolate'],
            Notification::FIELD_SUBJECT_LINK => null,
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
            Notification::FIELD_ID => 1,
            Notification::FIELD_USER_ID => 1,
            Notification::FIELD_NOTIFICATION_TYPE_ID => 1,
            Notification::FIELD_NOTIFICATION_HEADER => 'A payment has been recorded.',
            Notification::FIELD_NOTIFICATION_SOURCE => 'System Generated',
            Notification::FIELD_BODY_CONTENT => ['Chocolate'],
            Notification::FIELD_SUBJECT_LINK => null,
            Notification::FIELD_EMAIL_CODE => null,
        ];
        $dates = [
            Notification::FIELD_CREATED,
            Notification::FIELD_READ_DATE,
            Notification::FIELD_DELETED,
        ];

        $this->validateInitialise($expected, $this->Notifications, 1, $dates);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $good = $this->getGood();

        $new = $this->Notifications->newEntity($good);
        TestCase::assertInstanceOf(Notification::class, $this->Notifications->save($new));

        $required = [
            Notification::FIELD_NOTIFICATION_TYPE_ID,
            Notification::FIELD_NOTIFICATION_HEADER,
            Notification::FIELD_NOTIFICATION_SOURCE,
        ];

        $this->validateRequired($required, $this->Notifications, [$this, 'getGood']);

        $notRequired = [
            Notification::FIELD_ID,
            Notification::FIELD_USER_ID,
            Notification::FIELD_BODY_CONTENT,
            Notification::FIELD_SUBJECT_LINK,
            Notification::FIELD_EMAIL_CODE,
        ];

        $this->validateNotRequired($notRequired, $this->Notifications, [$this, 'getGood']);

        $notEmpties = [
            Notification::FIELD_NOTIFICATION_TYPE_ID,
            Notification::FIELD_NOTIFICATION_HEADER,
            Notification::FIELD_NOTIFICATION_SOURCE,
        ];

        $this->validateNotEmpties($notEmpties, $this->Notifications, [$this, 'getGood']);

        $empties = [
            Notification::FIELD_ID,
            Notification::FIELD_USER_ID,
            Notification::FIELD_BODY_CONTENT,
            Notification::FIELD_SUBJECT_LINK,
            Notification::FIELD_EMAIL_CODE,
        ];

        $this->validateEmpties($empties, $this->Notifications, [$this, 'getGood']);

        $maxLengths = [
            Notification::FIELD_NOTIFICATION_HEADER => 255,
            Notification::FIELD_NOTIFICATION_SOURCE => 63,
        ];

        $this->validateMaxLengths($maxLengths, $this->Notifications, [$this, 'getGood']);
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $foreignKeys = [
            Notification::FIELD_USER_ID => $this->Notifications->Users,
            Notification::FIELD_NOTIFICATION_TYPE_ID => $this->Notifications->NotificationTypes,
        ];
        $this->validateExistsRules($foreignKeys, $this->Notifications, [$this, 'getGood']);
    }

    /**
     * Test findUnread method
     *
     * @return void
     */
    public function testFindUnread(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test markRead method
     *
     * @return void
     */
    public function testMarkRead(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

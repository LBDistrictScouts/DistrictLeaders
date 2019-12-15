<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NotificationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\Utility\Security;

/**
 * App\Model\Table\NotificationsTable Test Case
 */
class NotificationsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\NotificationsTable
     */
    public $Notifications;

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
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Notifications') ? [] : ['className' => NotificationsTable::class];
        $this->Notifications = TableRegistry::getTableLocator()->get('Notifications', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Notifications);

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
        $good = [
            'user_id' => 1,
            'notification_type_id' => 1,
            'new' => false,
            'notification_header' => 'A payment has been recorded.',
            'text' => 'We have received a payment and have recorded it against your invoice. Please check that everything is in order.',
            'created' => '2018-02-25 15:56:43',
            'read_date' => '2018-02-25 15:58:04',
            'notification_source' => 'System Generated',
            'link_id' => 2,
            'link_controller' => 'Invoices',
            'link_prefix' => null,
            'link_action' => 'view',
            'deleted' => null,
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
        $actual = $this->Notifications->get(1)->toArray();

        $dates = [
            'created',
            'deleted',
            'read_date',
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
            'user_id' => 1,
            'notification_type_id' => 1,
            'new' => false,
            'notification_header' => 'A payment has been recorded.',
            'text' => 'We have received a payment and have recorded it against your invoice. Please check that everything is in order.',
            'notification_source' => 'System Generated',
            'link_id' => 2,
            'link_controller' => 'Invoices',
            'link_prefix' => null,
            'link_action' => 'view',
        ];
        TestCase::assertEquals($expected, $actual);

        $count = $this->Notifications->find('all')->count();
        TestCase::assertEquals(1, $count);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $good = $this->getGood();

        $new = $this->Notifications->newEntity($good);
        TestCase::assertInstanceOf('App\Model\Entity\Notification', $this->Notifications->save($new));

        $required = [
            'notification_header',
        ];

        foreach ($required as $require) {
            $reqArray = $this->getGood();
            unset($reqArray[$require]);
            $new = $this->Notifications->newEntity($reqArray);
            TestCase::assertFalse($this->Notifications->save($new));
        }

        $notEmpties = [
            'link_controller',
            'link_action',
        ];

        foreach ($notEmpties as $not_empty) {
            $reqArray = $this->getGood();
            $reqArray[$not_empty] = '';
            $new = $this->Notifications->newEntity($reqArray);
            TestCase::assertFalse($this->Notifications->save($new));
        }

        $maxLengths = [
            'link_action' => 45,
            'link_prefix' => 45,
            'link_controller' => 45,
            'notification_source' => 63,
            'notification_header' => 45,
        ];

        $string = hash('sha512', Security::randomBytes(64));
        $string .= $string;
        $string .= $string;

        foreach ($maxLengths as $maxField => $max_length) {
            $reqArray = $this->getGood();
            $reqArray[$maxField] = substr($string, 1, $max_length);
            $new = $this->Notifications->newEntity($reqArray);
            TestCase::assertInstanceOf('App\Model\Entity\Notification', $this->Notifications->save($new));

            $reqArray = $this->getGood();
            $reqArray[$maxField] = substr($string, 1, $max_length + 1);
            $new = $this->Notifications->newEntity($reqArray);
            TestCase::assertFalse($this->Notifications->save($new));
        }
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        // Notification Type Exists
        $values = $this->getGood();

        $groups = $this->Notifications->NotificationTypes->find('list')->toArray();

        $group = max(array_keys($groups));

        $values['notification_type_id'] = $group;
        $new = $this->Notifications->newEntity($values);
        TestCase::assertInstanceOf('App\Model\Entity\Notification', $this->Notifications->save($new));

        $values['notification_type_id'] = $group + 1;
        $new = $this->Notifications->newEntity($values);
        TestCase::assertFalse($this->Notifications->save($new));

        // User Exists
        $values = $this->getGood();

        $groups = $this->Notifications->Users->find('list')->toArray();

        $group = max(array_keys($groups));

        $values['user_id'] = $group;
        $new = $this->Notifications->newEntity($values);
        TestCase::assertInstanceOf('App\Model\Entity\Notification', $this->Notifications->save($new));

        $values['user_id'] = $group + 1;
        $new = $this->Notifications->newEntity($values);
        TestCase::assertFalse($this->Notifications->save($new));
    }
}

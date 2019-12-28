<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmailResponsesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmailResponsesTable Test Case
 */
class EmailResponsesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EmailResponsesTable
     */
    public $EmailResponses;

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
        'app.CampRoleTypes',
        'app.CampRoles',
        'app.Camps',
        'app.CampTypes',
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
        $config = TableRegistry::getTableLocator()->exists('EmailResponses') ? [] : ['className' => EmailResponsesTable::class];
        $this->EmailResponses = TableRegistry::getTableLocator()->get('EmailResponses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EmailResponses);

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
            'email_send_id' => 1,
            'email_response_type_id' => 1,
            'link_clicked' => 'Lorem ipsum dolor sit amet',
            'ip_address' => 'Lorem ipsum dolor sit amet',
            'bounce_reason' => 'Lorem ipsum dolor sit amet',
            'message_size' => 1,
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
        $actual = $this->EmailResponses->get(1)->toArray();

        $dates = [
            'received',
            'created',
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
            'email_send_id' => 1,
            'email_response_type_id' => 1,
            'link_clicked' => 'Lorem ipsum dolor sit amet',
            'ip_address' => 'Lorem ipsum dolor sit amet',
            'bounce_reason' => 'Lorem ipsum dolor sit amet',
            'message_size' => 1,
        ];
        TestCase::assertEquals($expected, $actual);

        $count = $this->EmailResponses->find('all')->count();
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

        $new = $this->EmailResponses->newEntity($good);
        TestCase::assertInstanceOf('App\Model\Entity\EmailResponse', $this->EmailResponses->save($new));

        $required = [
            'email_send_id',
            'email_response_type_id',
        ];

        foreach ($required as $require) {
            $reqArray = $this->getGood();
            unset($reqArray[$require]);
            $new = $this->EmailResponses->newEntity($reqArray);
            TestCase::assertFalse($this->EmailResponses->save($new));
        }

        $empties = [
            'link_clicked',
            'ip_address',
            'bounce_reason',
            'message_size',
        ];

        foreach ($empties as $empty) {
            $reqArray = $good;
            $reqArray[$empty] = '';
            $new = $this->EmailResponses->newEntity($reqArray);
            TestCase::assertInstanceOf('App\Model\Entity\EmailResponse', $this->EmailResponses->save($new));
        }

        $notEmpties = [
            'received',
            'email_send_id',
            'email_response_type_id',
        ];

        foreach ($notEmpties as $notEmpty) {
            $reqArray = $this->getGood();
            $reqArray[$notEmpty] = '';
            $new = $this->EmailResponses->newEntity($reqArray);
            TestCase::assertFalse($this->EmailResponses->save($new));
        }
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        // EmailResponse Type Exists
        $values = $this->getGood();

        $types = $this->EmailResponses->EmailResponseTypes->find('list')->toArray();

        $type = max(array_keys($types));

        $values['email_response_type_id'] = $type;
        $new = $this->EmailResponses->newEntity($values);
        TestCase::assertInstanceOf('App\Model\Entity\EmailResponse', $this->EmailResponses->save($new));

        $values['email_response_type_id'] = $type + 1;
        $new = $this->EmailResponses->newEntity($values);
        TestCase::assertFalse($this->EmailResponses->save($new));

        // Email Send Exists
        $values = $this->getGood();

        $types = $this->EmailResponses->EmailSends->find('list')->toArray();

        $type = max(array_keys($types));

        $values['email_send_id'] = $type;
        $new = $this->EmailResponses->newEntity($values);
        TestCase::assertInstanceOf('App\Model\Entity\EmailResponse', $this->EmailResponses->save($new));

        $values['email_send_id'] = $type + 1;
        $new = $this->EmailResponses->newEntity($values);
        TestCase::assertFalse($this->EmailResponses->save($new));
    }
}

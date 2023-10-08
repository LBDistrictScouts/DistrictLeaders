<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\EmailResponse;
use App\Model\Table\EmailResponsesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmailResponsesTable Test Case
 */
class EmailResponsesTableTest extends TestCase
{
    use ModelTestTrait;

    /**
     * Test subject
     *
     * @var EmailResponsesTable
     */
    public $EmailResponses;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('EmailResponses') ? [] : ['className' => EmailResponsesTable::class];
        $this->EmailResponses = $this->getTableLocator()->get('EmailResponses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->EmailResponses);

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
        $expected = [
            'id' => 1,
            'email_send_id' => 1,
            'email_response_type_id' => 1,
            'link_clicked' => 'Lorem ipsum dolor sit amet',
            'ip_address' => 'Lorem ipsum dolor sit amet',
            'bounce_reason' => 'Lorem ipsum dolor sit amet',
            'message_size' => 1,
        ];
        $dates = [
            'received',
            'created',
            'deleted',
        ];

        $this->validateInitialise($expected, $this->EmailResponses, 1, $dates);
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

        $new = $this->EmailResponses->newEntity($good);
        TestCase::assertInstanceOf('App\Model\Entity\EmailResponse', $this->EmailResponses->save($new));

        $required = [
            'email_send_id',
            'email_response_type_id',
        ];
        $this->validateRequired($required, $this->EmailResponses, [$this, 'getGood']);

        $notRequired = [
            'link_clicked',
            'ip_address',
            'bounce_reason',
            'message_size',
        ];
        $this->validateNotRequired($notRequired, $this->EmailResponses, [$this, 'getGood']);
        $this->validateEmpties($notRequired, $this->EmailResponses, [$this, 'getGood']);

        $notEmpties = [
            'received',
            'email_send_id',
            'email_response_type_id',
        ];
        $this->validateNotEmpties($notEmpties, $this->EmailResponses, [$this, 'getGood']);
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->validateExistsRule(
            EmailResponse::FIELD_EMAIL_RESPONSE_TYPE_ID,
            $this->EmailResponses,
            $this->EmailResponses->EmailResponseTypes,
            [$this, 'getGood']
        );

        // Email Send Exists
        $this->validateExistsRule(
            EmailResponse::FIELD_EMAIL_SEND_ID,
            $this->EmailResponses,
            $this->EmailResponses->EmailSends,
            [$this, 'getGood']
        );
    }
}

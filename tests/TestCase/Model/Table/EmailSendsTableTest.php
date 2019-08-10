<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmailSendsTable;
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
        'app.EmailSends',
        'app.Users',
        'app.Notifications',
        'app.NotificationTypes',
        'app.EmailResponses',
        'app.EmailResponseTypes',
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
        'app.Tokens',
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
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

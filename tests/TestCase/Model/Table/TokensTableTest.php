<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TokensTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TokensTable Test Case
 */
class TokensTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TokensTable
     */
    public $Tokens;

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
        $config = TableRegistry::getTableLocator()->exists('Tokens') ? [] : ['className' => TokensTable::class];
        $this->Tokens = TableRegistry::getTableLocator()->get('Tokens', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Tokens);

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

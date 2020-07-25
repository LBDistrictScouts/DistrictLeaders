<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\DirectoryDomain;
use App\Model\Table\DirectoryDomainsTable;
use App\Utility\TextSafe;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DirectoryDomainsTable Test Case
 */
class DirectoryDomainsTableTest extends TestCase
{
    use ModelTestTrait;

    /**
     * Test subject
     *
     * @var \App\Model\Table\DirectoryDomainsTable
     */
    protected $DirectoryDomains;

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
        'app.NotificationTypes',
        'app.Notifications',
        'app.EmailSends',
        'app.Tokens',
        'app.EmailResponseTypes',
        'app.EmailResponses',

        'app.DirectoryTypes',
        'app.Directories',
        'app.DirectoryDomains',
        'app.DirectoryUsers',
        'app.DirectoryGroups',
        'app.RoleTypesDirectoryGroups',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('DirectoryDomains') ? [] : ['className' => DirectoryDomainsTable::class];
        $this->DirectoryDomains = $this->getTableLocator()->get('DirectoryDomains', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->DirectoryDomains);

        parent::tearDown();
    }

    public function getGood(): array
    {
        return [
            DirectoryDomain::FIELD_DIRECTORY_DOMAIN => TextSafe::shuffle(20),
            DirectoryDomain::FIELD_DIRECTORY_ID => 1,
            DirectoryDomain::FIELD_INGEST => true,
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
            DirectoryDomain::FIELD_ID => 1,
            DirectoryDomain::FIELD_DIRECTORY_DOMAIN => 'Lorem ipsum dolor sit amet',
            DirectoryDomain::FIELD_DIRECTORY_ID => 1,
            DirectoryDomain::FIELD_INGEST => true,
        ];

        $this->validateInitialise($expected, $this->DirectoryDomains, 1);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

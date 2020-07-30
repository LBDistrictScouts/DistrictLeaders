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
            DirectoryDomain::FIELD_DIRECTORY_DOMAIN => 'goatface.org.uk',
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
        $new = $this->DirectoryDomains->newEntity($this->getGood());
        TestCase::assertInstanceOf(DirectoryDomain::class, $this->DirectoryDomains->save($new));

        $required = [
            DirectoryDomain::FIELD_DIRECTORY_ID,
            DirectoryDomain::FIELD_DIRECTORY_DOMAIN,
        ];
        $this->validateRequired($required, $this->DirectoryDomains, [$this, 'getGood']);

        $notRequired = [
            DirectoryDomain::FIELD_INGEST,
        ];
        $this->validateNotRequired($notRequired, $this->DirectoryDomains, [$this, 'getGood']);

        $notEmpties = [
            DirectoryDomain::FIELD_DIRECTORY_ID,
            DirectoryDomain::FIELD_DIRECTORY_DOMAIN,
            DirectoryDomain::FIELD_INGEST,
        ];
        $this->validateNotEmpties($notEmpties, $this->DirectoryDomains, [$this, 'getGood']);

        $maxLengths = [
            DirectoryDomain::FIELD_DIRECTORY_DOMAIN => 255,
        ];
        $this->validateMaxLengths($maxLengths, $this->DirectoryDomains, [$this, 'getGood']);
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->validateExistsRule(
            DirectoryDomain::FIELD_DIRECTORY_ID,
            $this->DirectoryDomains,
            $this->DirectoryDomains->Directories,
            [$this, 'getGood']
        );

        $this->validateUniqueRule(
            DirectoryDomain::FIELD_DIRECTORY_DOMAIN,
            $this->DirectoryDomains,
            [$this, 'getGood']
        );
    }
}

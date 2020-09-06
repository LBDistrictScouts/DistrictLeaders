<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Entity\DirectoryUser;
use App\Model\Table\DirectoryUsersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DirectoryUsersTable Test Case
 */
class DirectoryUsersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DirectoryUsersTable
     */
    protected $DirectoryUsers;

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
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('DirectoryUsers') ? [] : ['className' => DirectoryUsersTable::class];
        $this->DirectoryUsers = $this->getTableLocator()->get('DirectoryUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->DirectoryUsers);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize(): void
    {
        $expected = [
            DirectoryUser::FIELD_ID => 1,
            DirectoryUser::FIELD_DIRECTORY_ID => 1,
            DirectoryUser::FIELD_DIRECTORY_USER_REFERENCE => 'Lorem ipsum dolor sit amet',
            DirectoryUser::FIELD_GIVEN_NAME => 'Joesph',
            DirectoryUser::FIELD_FAMILY_NAME => 'Bloggs',
            DirectoryUser::FIELD_PRIMARY_EMAIL => 'fish@4thgoat.org.uk',
            DirectoryUser::FIELD_FULL_NAME => 'Joesph Bloggs',
        ];

        TestCase::assertEquals($expected, $this->DirectoryUsers->get(1)->toArray());
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

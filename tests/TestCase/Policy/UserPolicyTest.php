<?php
declare(strict_types=1);

namespace App\Test\TestCase\Policy;

use Cake\TestSuite\TestCase;

/**
 * Class UserPolicyTest
 *
 * @package App\Test\TestCase\Policy
 */
class UserPolicyTest extends TestCase
{
    use PolicyTestTrait;

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

        'app.FileTypes',
        'app.DocumentTypes',
        'app.Documents',
        'app.DocumentVersions',
        'app.DocumentEditions',

    ];

    /**
     * @var string $controller The Name of the controller being interrogated.
     */
    private $controller = 'Users';

    public function testCanIndex()
    {
        $this->tryIndexWith($this->controller);
        $this->tryIndexWithout($this->controller);
    }

    public function testCanView()
    {
        $this->tryViewWith($this->controller);
        $this->tryViewWithout($this->controller);

//        $this->tryViewWith($this->controller, 'OWN_USER');
//        $this->tryViewWithout($this->controller, ['OWN_USER', 'VIEW_USER']);
    }

//    public function testCanUpdate()
//    {
//    }
}

<?php
declare(strict_types=1);

namespace App\Test\TestCase\Command;

use App\Model\Entity\FileType;
use Cake\Console\Command;
use Cake\TestSuite\ConsoleIntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * Class InstallBaseCommandTest
 *
 * @package App\Test\TestCase\Command
 * @uses \App\Command\InstallBaseCommand
 */
class InstallBaseCommandTest extends TestCase
{
    use ConsoleIntegrationTestTrait;

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
        'app.NotificationTypes',
        'app.Notifications',
        'app.EmailSends',
        'app.Tokens',
        'app.EmailResponseTypes',
        'app.EmailResponses',

        'app.FileTypes',
        'app.DocumentTypes',
        'app.Documents',
        'app.DocumentVersions',
        'app.DocumentEditions',
    ];

    /**
     * Setup Function
     */
    public function setUp()
    {
        parent::setUp();
        $this->useCommandRunner();
    }

    /**
     * Description Output
     *
     * @return void
     */
    public function testDescriptionOutput()
    {
        $this->exec('install_base --help');
        $this->assertOutputContains('Install Configuration Options.');
    }

    /**
     * Description Output
     *
     * @return void
     */
    public function testInstallAll()
    {
        $this->exec('install_base -a');
        $this->assertExitCode(Command::CODE_SUCCESS);

        $this->assertOutputContains('Capabilities Installed:');
        $this->assertOutputContains('File Types Installed:');
        $this->assertOutputContains('Notification Types Installed:');
        $this->assertOutputContains('Role Templates Installed:');
    }

    /**
     * Description Output
     *
     * @return void
     */
    public function testInstallCapabilities()
    {
        $this->exec('install_base -c');
        $this->assertExitCode(Command::CODE_SUCCESS);

        $this->assertOutputContains('Capabilities Installed:');
    }

    /**
     * Description Output
     *
     * @return void
     */
    public function testInstallFileTypes()
    {
        $this->exec('install_base -f');
        $this->assertExitCode(Command::CODE_SUCCESS);

        $this->assertOutputContains('File Types Installed:');
    }

    /**
     * Description Output
     *
     * @return void
     */
    public function testInstallNotificationTypes()
    {
        $this->exec('install_base -n');
        $this->assertExitCode(Command::CODE_SUCCESS);

        $this->assertOutputContains('Notification Types Installed:');
    }

    /**
     * Description Output
     *
     * @return void
     */
    public function testInstallRoleTemplates()
    {
        $this->exec('install_base -r');
        $this->assertExitCode(Command::CODE_SUCCESS);

        $this->assertOutputContains('Role Templates Installed:');
    }
}

<?php
declare(strict_types=1);

namespace App\Test\TestCase\Command;

use App\Test\Fixture\FixtureTestTrait;
use Cake\Console\Command;
use Cake\TestSuite\ConsoleIntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * Class InstallBaseCommandTest
 *
 * @package App\Test\TestCase\Command
 * @uses \App\Command\ImportCompassRecordsCommand
 * @uses \App\Command\InstallBaseCommand
 */
class InstallBaseCommandTest extends TestCase
{
    use ConsoleIntegrationTestTrait;
    use FixtureTestTrait;

    /**
     * Setup Function
     */
    public function setUp(): void
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
    public function testInstallDirectoryTypes()
    {
        $this->exec('install_base -d');
        $this->assertExitCode(Command::CODE_SUCCESS);

        $this->assertOutputContains('Directory Types Installed:');
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

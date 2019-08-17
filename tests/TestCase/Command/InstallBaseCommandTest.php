<?php
namespace App\Test\TestCase\Command;

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
        'app.Capabilities'
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
    public function testInstallCapabilities()
    {
        $this->exec('install_base -c');
        $this->assertExitCode(Command::CODE_SUCCESS);

        $this->assertOutputContains('Capabilities Installed:');
    }
}

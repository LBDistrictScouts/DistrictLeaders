<?php
namespace App\Test\TestCase\Command;

use Cake\Console\Command;
use Cake\I18n\FrozenTime;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\ConsoleIntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * Class UpdateTableCommandTest
 *
 * @package App\Test\TestCase\Command
 *
 * @property \App\Model\Table\EventsTable $Events
 */
class UpdateTableCommandTest extends TestCase
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

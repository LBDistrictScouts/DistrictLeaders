<?php

declare(strict_types=1);

namespace App\Test\TestCase\Command;

use App\Test\Fixture\FixtureTestTrait;
use Cake\Console\Command;
use Cake\TestSuite\ConsoleIntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * Class PermissionsCommandTest
 *
 * @package App\Test\TestCase\Command
 * @uses \App\Command\PermissionsCommand
 */
class PermissionsCommandTest extends TestCase
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
        $this->exec('permissions --help');
        $this->assertOutputContains('Update the Permissions for Users.');
    }

    /**
     * Description Output
     *
     * @return void
     */
    public function testInstallCapabilities()
    {
        $this->exec('permissions -c');
        $this->assertExitCode(Command::CODE_SUCCESS);

        $this->assertOutputContains('User Capabilities Patched:');
    }
}

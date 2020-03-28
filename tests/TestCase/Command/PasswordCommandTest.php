<?php
declare(strict_types=1);

namespace App\Test\TestCase\Command;

use Cake\Console\Command;
use Cake\TestSuite\ConsoleIntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * Class InstallBaseCommandTest
 *
 * @package App\Test\TestCase\Command
 * @uses \App\Command\PasswordCommand
 */
class PasswordCommandTest extends TestCase
{
    use ConsoleIntegrationTestTrait;

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
    ];

    /**
     * Setup Function
     *
     * @throws \Exception
     */
    public function setUp()
    {
        parent::setUp();
        $this->loadFixtures();
        $this->useCommandRunner();
    }

    /**
     * Description Output
     *
     * @return void
     */
    public function testDescriptionOutput()
    {
        $this->exec('password --help');
        $this->assertOutputContains('Set a the default user password.');
    }

    /**
     * Description Output
     *
     * @return void
     */
    public function testPasswordUpdate()
    {
        $this->exec('password Cheese');
        $this->assertExitCode(Command::CODE_SUCCESS);

        $this->assertOutputContains('User created.');
        $this->assertOutputContains('User updated with Password.');

        $this->exec('password');
        $this->assertExitCode(Command::CODE_ERROR);
        $this->assertErrorContains('Password not listed.');

        $this->exec('password Goat');
        $this->assertExitCode(Command::CODE_SUCCESS);

        $this->assertOutputNotContains('User created.');
        $this->assertOutputContains('User updated with Password.');
    }
}

<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\ORM\Locator\LocatorAwareTrait;

/**
 * Class PasswordCommand
 *
 * @package App\Command
 * @property \App\Model\Table\UsersTable $Users
 */
class PermissionsCommand extends Command
{
    use LocatorAwareTrait;

    /**
     * Initialise method
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->Users = $this->fetchTable('Users');
    }

    /**
     * @param \Cake\Console\ConsoleOptionParser $parser Parser Input
     * @return \Cake\Console\ConsoleOptionParser
     */
    protected function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser->setDescription('Update the Permissions for Users.');

        $parser
            ->addOption('all', [
                'short' => 'a',
                'help' => 'All Schedules',
                'boolean' => true,
            ])
            ->addOption('capabilities', [
                'short' => 'c',
                'help' => 'Capabilities',
                'boolean' => true,
            ]);

        return $parser;
    }

    /**
     * @param \Cake\Console\Arguments $args Arguments for the Console
     * @param \Cake\Console\ConsoleIo $consoleIo The IO
     * @return void
     * @throws \Exception
     * @SuppressWarnings(PHPMD.ShortVariable)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function execute(Arguments $args, ConsoleIo $consoleIo): void
    {
        if ($args->getOption('all') || $args->getOption('capabilities')) {
            $users = $this->Users->find('all');
            $happenings = 0;

            foreach ($users as $user) {
                if ($this->Users->patchCapabilities($user)) {
                    $happenings += 1;
                }
            }

            $consoleIo->info('User Capabilities Patched: ' . $happenings);
        }
    }
}

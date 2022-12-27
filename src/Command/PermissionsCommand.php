<?php
declare(strict_types=1);

namespace App\Command;

use App\Model\Table\UsersTable;
use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Exception;

/**
 * Class PasswordCommand
 *
 * @package App\Command
 * @property UsersTable $Users
 */
class PermissionsCommand extends Command
{
    /**
     * Initialise method
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('Users');
    }

    /**
     * @param ConsoleOptionParser $parser Parser Input
     * @return ConsoleOptionParser
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
     * @param Arguments $args Arguments for the Console
     * @param ConsoleIo $consoleIo The IO
     * @return int|void|null
     * @throws Exception
     * @SuppressWarnings(PHPMD.ShortVariable)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function execute(Arguments $args, ConsoleIo $consoleIo)
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

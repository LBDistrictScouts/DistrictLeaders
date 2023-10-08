<?php
declare(strict_types=1);

namespace App\Command;

use App\Cron\Cron;
use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

/**
 * Class PasswordCommand
 *
 * @package App\Command
 */
class DailyCommand extends Command
{
    /**
     * Initialise method
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
    }

    /**
     * @param \Cake\Console\ConsoleOptionParser $parser Parser Input
     * @return \Cake\Console\ConsoleOptionParser
     */
    protected function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser->setDescription('Send unsent Emails.');

        return $parser;
    }

    /**
     * @param \Cake\Console\Arguments $args Arguments for the Console
     * @param \Cake\Console\ConsoleIo $consoleIo The IO
     * @return int|null
     * @throws \Exception
     * @SuppressWarnings(PHPMD.ShortVariable)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function execute(Arguments $args, ConsoleIo $consoleIo): ?int
    {
        $tasks = Cron::collectCronClasses();
        $success = 0;

        foreach ($tasks as $class) {
            /** @var \App\Cron\Cron $taskClass */
            $taskClass = new $class();

            if (get_parent_class($taskClass) == 'App\Cron\Cron') {
                $success += $taskClass->scheduleJobs();
            }
        }

        $consoleIo->info('Scheduled daily tasks: ' . (string)$success);
    }
}

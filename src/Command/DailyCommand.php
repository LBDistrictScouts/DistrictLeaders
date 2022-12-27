<?php

declare(strict_types=1);

namespace App\Command;

use App\Cron\Cron;
use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Exception;

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
     * @param ConsoleOptionParser $parser Parser Input
     * @return ConsoleOptionParser
     */
    protected function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser->setDescription('Send unsent Emails.');

        return $parser;
    }

    /**
     * @param Arguments $args Arguments for the Console
     * @param ConsoleIo $consoleIo The IO
     * @return int|void|null
     * @throws Exception
     * @SuppressWarnings(PHPMD.ShortVariable)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function execute(Arguments $args, ConsoleIo $consoleIo)
    {
        $tasks = Cron::collectCronClasses();
        $success = 0;

        foreach ($tasks as $class) {
            /** @var Cron $taskClass */
            $taskClass = new $class();

            if (get_parent_class($taskClass) == 'App\Cron\Cron') {
                $success += $taskClass->scheduleJobs();
            }
        }

        $consoleIo->info('Scheduled daily tasks: ' . (string)$success);
    }
}

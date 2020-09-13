<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

/**
 * Class PasswordCommand
 *
 * @package App\Command
 * @property \App\Model\Table\DirectoriesTable $Directories
 */
class DirectoryCommand extends Command
{
    /**
     * Initialise method
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('Directories');
    }

    /**
     * @param \Cake\Console\ConsoleOptionParser $parser Parser Input
     * @return \Cake\Console\ConsoleOptionParser
     */
    protected function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser->setDescription('Populate Directory Information.');

        $parser
            ->addOption('all', [
                'short' => 'a',
                'help' => 'All Directory Objects',
                'boolean' => true,
            ])
            ->addOption('directory_id', [
            'short' => 'd',
            'help' => 'Directory ID',
            'boolean' => false,
            ]);

        return $parser;
    }

    /**
     * @param \Cake\Console\Arguments $args Arguments for the Console
     * @param \Cake\Console\ConsoleIo $consoleIo The IO
     * @return int|void|null
     * @throws \Exception
     * @SuppressWarnings(PHPMD.ShortVariable)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function execute(Arguments $args, ConsoleIo $consoleIo)
    {
        $directoryId = (int)$args->getOption('directory_id');
        if (!is_integer($directoryId)) {
            return $consoleIo->error('Directory ID not Specified');
        }

        $directory = $this->Directories->get($directoryId);
        $consoleIo->info('Directory: ' . $directory->directory);

        if ($args->getOption('all')) {
            $happenings = $this->Directories->populate($directory);

            $tableOut = [
                ['Association', 'Updates'],
            ];
            foreach ($happenings as $association => $count) {
                $association = ucwords(str_replace('Count', '', $association));
                array_push($tableOut, [$association, (string)$count]);
            }
            $consoleIo->helper('Table')->output($tableOut);
        }
    }
}

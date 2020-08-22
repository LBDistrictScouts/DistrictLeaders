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
 * @property \App\Model\Table\DocumentVersionsTable $DocumentVersions
 */
class ImportCompassRecordsCommand extends Command
{
    /**
     * Initialise method
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('DocumentVersions');
    }

    /**
     * @param \Cake\Console\ConsoleOptionParser $parser Parser Input
     * @return \Cake\Console\ConsoleOptionParser
     */
    protected function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser->setDescription('Install Configuration Options.');

        $parser
            ->addOption('document_version_id', [
                'short' => 'v',
                'help' => 'ID of the Document Version',
                'boolean' => false,
            ]);

        return $parser;
    }

    /**
     * @param \Cake\Console\Arguments $args Arguments for the Console
     * @param \Cake\Console\ConsoleIo $io The IO
     * @return int|void|null
     * @throws \Exception
     * @SuppressWarnings(PHPMD.ShortVariable)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $directoryId = (int)$args->getOption('document_version_id');
        if (!is_integer($directoryId)) {
            return $io->error('Document Version ID not Specified');
        }

        $documentVersion = $this->DocumentVersions->get($directoryId);

        $this->DocumentVersions->importCompassRecords($documentVersion);
    }
}

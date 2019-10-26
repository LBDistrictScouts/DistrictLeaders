<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Mailer\MailerAwareTrait;

/**
 * Class PasswordCommand
 *
 * @package App\Command
 *
 * @property \App\Model\Table\CapabilitiesTable $Capabilities
 * @property \App\Model\Table\NotificationTypesTable $NotificationTypes
 */
class InstallBaseCommand extends Command
{
    use MailerAwareTrait;

    /**
     * Initialise method
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Capabilities');
        $this->loadModel('NotificationTypes');
    }

    /**
     * @param \Cake\Console\ConsoleOptionParser $parser Parser Input
     *
     * @return \Cake\Console\ConsoleOptionParser
     */
    protected function buildOptionParser(ConsoleOptionParser $parser)
    {
        $parser->setDescription('Install Configuration Options.');

        $parser
            ->addOption('all', [
                'short' => 'a',
                'help' => 'All Base Objects',
                'boolean' => true,
            ])
            ->addOption('capabilities', [
                'short' => 'c',
                'help' => 'Capabilities',
                'boolean' => true,
            ])
            ->addOption('notification_types', [
                'short' => 'n',
                'help' => 'Notification Types',
                'boolean' => true,
            ]);

        return $parser;
    }

    /**
     * @param \Cake\Console\Arguments $args Arguments for the Console
     * @param \Cake\Console\ConsoleIo $io The IO
     *
     * @return int|void|null
     *
     * @throws \Exception
     *
     * @SuppressWarnings(PHPMD.ShortVariable)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function execute(Arguments $args, ConsoleIo $io)
    {
        if ($args->getOption('all') || $args->getOption('capabilities')) {
            $happenings = $this->Capabilities->installBaseCapabilities();

            $io->info('Capabilities Installed: ' . $happenings);
        }

        if ($args->getOption('all') || $args->getOption('notification_types')) {
            $happenings = $this->NotificationTypes->installBaseTypes();

            $io->info('Notification Types Installed: ' . $happenings);
        }
    }
}

<?php
declare(strict_types=1);

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
 * @property \App\Model\Table\FileTypesTable $FileTypes
 * @property \App\Model\Table\RoleTemplatesTable $RoleTemplates
 */
class InstallBaseCommand extends Command
{
    use MailerAwareTrait;

    /**
     * Initialise method
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('Capabilities');
        $this->loadModel('NotificationTypes');
        $this->loadModel('FileTypes');
        $this->loadModel('RoleTemplates');
    }

    /**
     * @param \Cake\Console\ConsoleOptionParser $parser Parser Input
     *
     * @return \Cake\Console\ConsoleOptionParser
     */
    protected function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
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
            ->addOption('file_types', [
                'short' => 'f',
                'help' => 'File Types',
                'boolean' => true,
            ])
            ->addOption('role_templates', [
                'short' => 'r',
                'help' => 'Role Templates',
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
            $happenings = $this->NotificationTypes->installBaseNotificationTypes();

            $io->info('Notification Types Installed: ' . $happenings);
        }

        if ($args->getOption('all') || $args->getOption('file_types')) {
            $happenings = $this->FileTypes->installBaseFileTypes();

            $io->info('File Types Installed: ' . $happenings);
        }

        if ($args->getOption('all') || $args->getOption('role_templates')) {
            $happenings = $this->RoleTemplates->installBaseRoleTemplates();

            $io->info('Role Templates Installed: ' . $happenings);
        }
    }
}

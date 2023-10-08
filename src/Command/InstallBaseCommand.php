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
 * @property \App\Model\Table\CapabilitiesTable $Capabilities
 * @property \App\Model\Table\NotificationTypesTable $NotificationTypes
 * @property \App\Model\Table\FileTypesTable $FileTypes
 * @property \App\Model\Table\RoleTemplatesTable $RoleTemplates
 * @property \App\Model\Table\DirectoryTypesTable $DirectoryTypes
 * @property \App\Model\Table\UserStatesTable $UserStates
 * @property \App\Model\Table\DocumentTypesTable $DocumentTypes
 * @property \App\Model\Table\UserContactTypesTable $UserContactTypes
 */
class InstallBaseCommand extends Command
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
        $this->Capabilities = $this->fetchTable('Capabilities');
        $this->NotificationTypes = $this->fetchTable('NotificationTypes');
        $this->FileTypes = $this->fetchTable('FileTypes');
        $this->RoleTemplates = $this->fetchTable('RoleTemplates');
        $this->DirectoryTypes = $this->fetchTable('DirectoryTypes');
        $this->UserStates = $this->fetchTable('UserStates');
        $this->DocumentTypes = $this->fetchTable('DocumentTypes');
        $this->UserContactTypes = $this->fetchTable('UserContactTypes');
    }

    /**
     * @param \Cake\Console\ConsoleOptionParser $parser Parser Input
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
            ->addOption('directory_types', [
                'short' => 'd',
                'help' => 'Directory Types',
                'boolean' => true,
            ])
            ->addOption('role_templates', [
                'short' => 'r',
                'help' => 'Role Templates',
                'boolean' => true,
            ])
            ->addOption('document_types', [
                'short' => 'y',
                'help' => 'Document Types',
                'boolean' => true,
            ])
            ->addOption('notification_types', [
                'short' => 'n',
                'help' => 'Notification Types',
                'boolean' => true,
            ])
            ->addOption('user_contact_types', [
                'short' => 'u',
                'help' => 'User Contact Types',
                'boolean' => true,
            ]);

        return $parser;
    }

    /**
     * @param \Cake\Console\Arguments $args Arguments for the Console
     * @param \Cake\Console\ConsoleIo $io The IO
     * @return void
     * @throws \Exception
     * @SuppressWarnings(PHPMD.ShortVariable)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute(Arguments $args, ConsoleIo $io): void
    {
        if ($args->getOption('all') || $args->getOption('capabilities')) {
            $happenings = $this->Capabilities->installBaseCapabilities();

            $io->info('Capabilities Installed: ' . $happenings);
        }

        if ($args->getOption('all') || $args->getOption('notification_types')) {
            $happenings = $this->NotificationTypes->installBaseNotificationTypes();

            $io->info('Notification Types Installed: ' . $happenings);
        }

        if ($args->getOption('all') || $args->getOption('directory_types')) {
            $happenings = $this->DirectoryTypes->installBaseDirectoryTypes();

            $io->info('Directory Types Installed: ' . $happenings);
        }

        if ($args->getOption('all') || $args->getOption('file_types')) {
            $happenings = $this->FileTypes->installBaseFileTypes();

            $io->info('File Types Installed: ' . $happenings);
        }

        if ($args->getOption('all') || $args->getOption('role_templates')) {
            $happenings = $this->RoleTemplates->installBaseRoleTemplates();

            $io->info('Role Templates Installed: ' . $happenings);
        }

        if ($args->getOption('all') || $args->getOption('user_states')) {
            $happenings = $this->UserStates->installBaseUserStates();

            $io->info('User States Installed: ' . $happenings);
        }

        if ($args->getOption('all') || $args->getOption('document_types')) {
            $happenings = $this->DocumentTypes->installBaseDocumentTypes();

            $io->info('Document Types Installed: ' . $happenings);
        }

        if ($args->getOption('all') || $args->getOption('user_contact_types')) {
            $happenings = $this->UserContactTypes->installBaseUserContactTypes();

            $io->info('User Contact Types Installed: ' . $happenings);
        }
    }
}

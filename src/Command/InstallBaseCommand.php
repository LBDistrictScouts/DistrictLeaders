<?php

declare(strict_types=1);

namespace App\Command;

use App\Model\Table\CapabilitiesTable;
use App\Model\Table\DirectoryTypesTable;
use App\Model\Table\DocumentTypesTable;
use App\Model\Table\FileTypesTable;
use App\Model\Table\NotificationTypesTable;
use App\Model\Table\RoleTemplatesTable;
use App\Model\Table\UserContactTypesTable;
use App\Model\Table\UserStatesTable;
use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\ORM\Locator\LocatorAwareTrait;
use Exception;

/**
 * Class PasswordCommand
 *
 * @package App\Command
 * @property CapabilitiesTable $Capabilities
 * @property NotificationTypesTable $NotificationTypes
 * @property FileTypesTable $FileTypes
 * @property RoleTemplatesTable $RoleTemplates
 * @property DirectoryTypesTable $DirectoryTypes
 * @property UserStatesTable $UserStates
 * @property DocumentTypesTable $DocumentTypes
 * @property UserContactTypesTable $UserContactTypes
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
     * @param ConsoleOptionParser $parser Parser Input
     * @return ConsoleOptionParser
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
     * @param Arguments $args Arguments for the Console
     * @param ConsoleIo $consoleIo The IO
     * @return int|void|null
     * @throws Exception
     * @SuppressWarnings(PHPMD.ShortVariable)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute(Arguments $args, ConsoleIo $consoleIo)
    {
        if ($args->getOption('all') || $args->getOption('capabilities')) {
            $happenings = $this->Capabilities->installBaseCapabilities();

            $consoleIo->info('Capabilities Installed: ' . $happenings);
        }

        if ($args->getOption('all') || $args->getOption('notification_types')) {
            $happenings = $this->NotificationTypes->installBaseNotificationTypes();

            $consoleIo->info('Notification Types Installed: ' . $happenings);
        }

        if ($args->getOption('all') || $args->getOption('directory_types')) {
            $happenings = $this->DirectoryTypes->installBaseDirectoryTypes();

            $consoleIo->info('Directory Types Installed: ' . $happenings);
        }

        if ($args->getOption('all') || $args->getOption('file_types')) {
            $happenings = $this->FileTypes->installBaseFileTypes();

            $consoleIo->info('File Types Installed: ' . $happenings);
        }

        if ($args->getOption('all') || $args->getOption('role_templates')) {
            $happenings = $this->RoleTemplates->installBaseRoleTemplates();

            $consoleIo->info('Role Templates Installed: ' . $happenings);
        }

        if ($args->getOption('all') || $args->getOption('user_states')) {
            $happenings = $this->UserStates->installBaseUserStates();

            $consoleIo->info('User States Installed: ' . $happenings);
        }

        if ($args->getOption('all') || $args->getOption('document_types')) {
            $happenings = $this->DocumentTypes->installBaseDocumentTypes();

            $consoleIo->info('Document Types Installed: ' . $happenings);
        }

        if ($args->getOption('all') || $args->getOption('user_contact_types')) {
            $happenings = $this->UserContactTypes->installBaseUserContactTypes();

            $consoleIo->info('User Contact Types Installed: ' . $happenings);
        }
    }
}

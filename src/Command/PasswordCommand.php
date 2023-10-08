<?php
declare(strict_types=1);

namespace App\Command;

use App\Model\Entity\User;
use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Core\Configure;
use Cake\Mailer\MailerAwareTrait;

/**
 * Class PasswordCommand
 *
 * @package App\Command
 * @property \App\Model\Table\UsersTable $Users
 */
class PasswordCommand extends Command
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
        $this->loadModel('Users');
    }

    /**
     * @param \Cake\Console\ConsoleOptionParser $parser Parser Input
     * @return \Cake\Console\ConsoleOptionParser
     */
    protected function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser->setDescription('Set a the default user password.');

        $parser
            ->addArgument('password', [
                'short' => 'p',
                'help' => 'Password Value to be Set',
            ]);

        return $parser;
    }

    /**
     * @param \Cake\Console\Arguments $args Arguments for the Console
     * @param \Cake\Console\ConsoleIo $consoleIo The IO
     * @return int|null|void
     * @throws \Exception
     * @SuppressWarnings(PHPMD.ShortVariable)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function execute(Arguments $args, ConsoleIo $consoleIo): int|null|null
    {
        if (!$args->hasArgument('password')) {
            $consoleIo->error('Password not listed.');
            $this->abort();
        }

        $adminUser = Configure::readOrFail('DefaultAdmin');

        $user = $this->Users->find()->where([
            User::FIELD_USERNAME => $adminUser['username'],
            User::FIELD_EMAIL => $adminUser['email'],
        ])->first();

        if (!($user instanceof User)) {
            $user = $this->Users->newEntity($adminUser);

            if (!$this->Users->save($user)) {
                foreach (array_values($user->getErrors()) as $error) {
                    foreach ($error as $message) {
                        $consoleIo->warning($message);
                    }
                }
                $consoleIo->error('User could not be saved.');
                $this->abort();
            }
            $consoleIo->info('User created.');
        }
        $user->set('password', $args->getArgument('password'));

        if (!$this->Users->save($user)) {
            $consoleIo->error('User could not be saved with Password.');
            $this->abort();
        }

        $consoleIo->info('User updated with Password.');
    }
}

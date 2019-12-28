<?php
declare(strict_types=1);

namespace App\Command;

use App\Model\Entity\User;
use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Core\Configure;
use Cake\Mailer\MailerAwareTrait;

/**
 * Class PasswordCommand
 *
 * @package App\Command
 *
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
     *
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
        if (!$args->hasArgument('password')) {
            $io->error('Password not listed.');
            $this->abort();
        }

        $adminUser = Configure::readOrFail('defaultAdmin');

        $user = $this->Users->find()->where([
            User::FIELD_USERNAME => $adminUser['username'],
            User::FIELD_EMAIL => $adminUser['email'],
        ])->first();

        if (!($user instanceof User)) {
            $user = $this->Users->newEntity($adminUser);

            if (!$this->Users->save($user)) {
                $io->error('User could not be saved.');
                $this->abort();
            }
            $io->info('User created.');
        }
        $user->set('password', $args->getArgument('password'));

        if (!$this->Users->save($user)) {
            $io->error('User could not be saved with Password.');
            $this->abort();
        }

        $io->info('User updated with Password.');
    }
}

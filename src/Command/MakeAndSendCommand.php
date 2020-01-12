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
 * @property \App\Model\Table\EmailSendsTable $EmailSends
 */
class MakeAndSendCommand extends Command
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
        $this->loadModel('EmailSends');
    }

    /**
     * @param \Cake\Console\ConsoleOptionParser $parser Parser Input
     *
     * @return \Cake\Console\ConsoleOptionParser
     */
    protected function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser->setDescription('Send Emails via command line');

        $parser->addArgument('code', [
            'required' => true,
            'help' => 'The email generation Code.',
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
        $io->info('Code "' . $args->getArgument('code') . '" initiated.');

        $result = $this->EmailSends->make($args->getArgument('code'));

        if (!$result) {
            $io->error('Email did not "Make" successfully.');

            return;
        }

        $result = $this->EmailSends->send($result);

        if (!$result) {
            $io->error('Email did not "Send" successfully.');

            return;
        }

        $io->info('Email Sent Successfully.');
    }
}

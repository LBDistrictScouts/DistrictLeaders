<?php

declare(strict_types=1);

namespace App\Command;

use App\Model\Table\EmailSendsTable;
use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Mailer\MailerAwareTrait;
use Exception;

/**
 * Class PasswordCommand
 *
 * @package App\Command
 * @property EmailSendsTable $EmailSends
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
     * @param ConsoleOptionParser $parser Parser Input
     * @return ConsoleOptionParser
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
     * @param Arguments $args Arguments for the Console
     * @param ConsoleIo $consoleIo The IO
     * @return int|void|null
     * @throws Exception
     * @SuppressWarnings(PHPMD.ShortVariable)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function execute(Arguments $args, ConsoleIo $consoleIo)
    {
        $consoleIo->info('Code "' . $args->getArgument('code') . '" initiated.');

        $result = $this->EmailSends->make($args->getArgument('code'));

        if (!$result) {
            $consoleIo->error('Email did not "Make" successfully.');

            return;
        }

        $result = $this->EmailSends->send($result->id);

        if (!$result) {
            $consoleIo->error('Email did not "Send" successfully.');

            return;
        }

        $consoleIo->info('Email Sent Successfully.');
    }
}

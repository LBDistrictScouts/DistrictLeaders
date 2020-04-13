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
 * @property \App\Model\Table\EmailSendsTable $EmailSends
 */
class UnsentCommand extends Command
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
     * @return \Cake\Console\ConsoleOptionParser
     */
    protected function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser->setDescription('Send unsent Emails.');

        return $parser;
    }

    /**
     * @param \Cake\Console\Arguments $args Arguments for the Console
     * @param \Cake\Console\ConsoleIo $io The IO
     * @return int|void|null
     * @throws \Exception
     * @SuppressWarnings(PHPMD.ShortVariable)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function execute(Arguments $args, ConsoleIo $io)
    {
        /** @var \App\Model\Entity\EmailSend[] $unsent */
        $unsent = $this->EmailSends->find('unsent');
        $found = 0;
        $sent = 0;

        foreach ($unsent as $email) {
            $success = $this->EmailSends->send($email->get($email::FIELD_ID));

            $found += 1;
            if ($success) {
                $sent += 1;
            }
        }

        $io->info($sent . ' Emails sent of ' . $found);
    }
}

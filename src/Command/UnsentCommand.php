<?php
declare(strict_types=1);

namespace App\Command;

use App\Model\Entity\EmailSend;
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
     * @param ConsoleOptionParser $parser Parser Input
     * @return ConsoleOptionParser
     */
    protected function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser->setDescription('Send unsent Emails.');

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
        /** @var EmailSend[] $unsent */
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

        $consoleIo->info($sent . ' Emails sent of ' . $found);
    }
}

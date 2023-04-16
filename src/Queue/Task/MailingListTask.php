<?php
declare(strict_types=1);

namespace App\Queue\Task;

use Queue\Model\QueueException;
use Queue\Queue\Task;
use Queue\Queue\TaskInterface;

/**
 * Class QueueMailingListTask
 *
 * @package App\Shell\Task
 * @property \App\Model\Table\EmailSendsTable $EmailSends
 */
class MailingListTask extends Task implements TaskInterface
{
    /**
     * @var int
     */
    // phpcs:ignore SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
    public $timeout = 300;

    /**
     * @var int
     */
    // phpcs:ignore SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
    public $retries = 1;

    /**
     * @param array $data The array passed to QueuedJobsTable::createJob()
     * @param int $jobId The id of the QueuedJob entity
     * @return void
     */
    public function run(array $data, int $jobId): void
    {
        if (!key_exists('email_generation_code', $data)) {
            throw new QueueException('Email generation code not specified.');
        }

        $this->loadModel('EmailSends');

        if (!$this->EmailSends->makeAndSend($data['email_generation_code'])) {
            throw new QueueException('Make & Send Failed.');
        }
    }
}

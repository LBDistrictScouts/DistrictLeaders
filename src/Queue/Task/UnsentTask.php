<?php
declare(strict_types=1);

namespace App\Queue\Task;

use Queue\Queue\Task;
use Queue\Queue\TaskInterface;

/**
 * Class QueueWelcomeTask
 *
 * @package App\Shell\Task
 * @property \App\Model\Table\EmailSendsTable $EmailSends
 */
class UnsentTask extends Task implements TaskInterface
{
    use JobDataTrait;

    /**
     * @var int
     */
    // phpcs:ignore SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
    public $timeout = 20;

    /**
     * @var int
     */
    // phpcs:ignore SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
    public $retries = 2;

    protected string $outputKey = 'output';

    /**
     * @param array $data The array passed to QueuedJobsTable::createJob()
     * @param int $jobId The id of the QueuedJob entity
     * @return void
     */
    public function run(array $data, int $jobId): void
    {
        $this->loadModel('EmailSends');

        /** @var array<\App\Queue\Task\EmailSend> $unsent */
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

        $this->saveJobResult((int)$jobId, __('{0} emails sent of {1} found.', $sent, $found), $this->outputKey);
    }
}

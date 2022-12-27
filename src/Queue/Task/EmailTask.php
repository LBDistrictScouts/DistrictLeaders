<?php

declare(strict_types=1);

namespace App\Queue\Task;

use App\Model\Table\EmailSendsTable;
use Queue\Model\QueueException;
use Queue\Model\Table\QueuedJobsTable;
use Queue\Queue\Task;
use Queue\Queue\TaskInterface;

/**
 * Class QueueWelcomeTask
 *
 * @package App\Shell\Task
 * @property EmailSendsTable $EmailSends
 * @property QueuedJobsTable $QueuedJobs
 */
class EmailTask extends Task implements TaskInterface
{
    use JobDataTrait;

    /**
     * @var int
     */
    public $timeout = 20;

    /**
     * @var int
     */
    public $retries = 1;

    protected string $entityKey = 'email_generation_code';

    /**
     * @param array $data The array passed to QueuedJobsTable::createJob()
     * @param int $jobId The id of the QueuedJob entity
     * @return void
     */
    public function run(array $data, $jobId): void
    {
        $this->checkEntityKey($data);

        $this->loadModel('EmailSends');
        $this->loadModel('Queue.QueuedJobs');

        $email = $this->EmailSends->make($data['email_generation_code']);

        if (!$email) {
            throw new QueueException('Make Failed.');
        }

        $this->saveJobDataArray((int)$jobId, ['email_send_id' => $email->id]);
    }
}

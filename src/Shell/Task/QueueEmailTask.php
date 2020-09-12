<?php
declare(strict_types=1);

namespace App\Shell\Task;

use Queue\Model\QueueException;
use Queue\Shell\Task\QueueTask;
use Queue\Shell\Task\QueueTaskInterface;

/**
 * Class QueueWelcomeTask
 *
 * @package App\Shell\Task
 * @property \App\Model\Table\EmailSendsTable EmailSends
 * @property \Queue\Model\Table\QueuedJobsTable $QueuedJobs
 */
class QueueEmailTask extends QueueTask implements QueueTaskInterface
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

    protected $entityKey = 'email_generation_code';

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

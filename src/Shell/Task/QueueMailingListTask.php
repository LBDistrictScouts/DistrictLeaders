<?php
declare(strict_types=1);

namespace App\Shell\Task;

use Queue\Model\QueueException;
use Queue\Shell\Task\QueueTask;

/**
 * Class QueueMailingListTask
 *
 * @package App\Shell\Task
 * @property \App\Model\Table\EmailSendsTable $EmailSends
 */
class QueueMailingListTask extends QueueTask
{
    /**
     * @var int
     */
    public $timeout = 300;

    /**
     * @var int
     */
    public $retries = 1;

    /**
     * @param array $data The array passed to QueuedJobsTable::createJob()
     * @param int $jobId The id of the QueuedJob entity
     * @return void
     */
    public function run(array $data, $jobId)
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

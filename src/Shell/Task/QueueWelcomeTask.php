<?php
namespace App\Shell\Task;

use Queue\Model\QueueException;
use Queue\Shell\Task\QueueTask;
use Queue\Shell\Task\QueueTaskInterface;

/**
 * Class QueueWelcomeTask
 *
 * @package App\Shell\Task
 *
 * @property \App\Model\Table\EmailSendsTable EmailSends
 */
class QueueWelcomeTask extends QueueTask implements QueueTaskInterface
{

    /**
     * @var int
     */
    public $timeout = 20;

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
        if (!key_exists('user_id', $data)) {
            throw new QueueException('No User ID specified.');
        }

        $this->loadModel('EmailSends');

        if (!$this->EmailSends->makeAndSend('USR-' . $data['user_id'] . '-NEW')) {
            throw new QueueException('Make & Send Failed.');
        }
    }
}

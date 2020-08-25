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
 * @property \App\Model\Table\DirectoriesTable $Directories
 * @property \Queue\Model\Table\QueuedJobsTable $QueuedJobs
 */
class QueueDirectoryTask extends QueueTask implements QueueTaskInterface
{
    /**
     * @var int
     */
    public $timeout = 900;

    /**
     * @var int
     */
    public $retries = 1;

    /**
     * @var string The Data Key
     */
    private $entityKey = 'directory';

    /**
     * @param array $data The array passed to QueuedJobsTable::createJob()
     * @param int $jobId The id of the QueuedJob entity
     * @return void
     */
    public function run(array $data, $jobId): void
    {
        if (!key_exists($this->entityKey, $data)) {
            throw new QueueException('Document Version Number not specified.');
        }

        $this->loadModel('Directories');
        $this->loadModel('Queue.QueuedJobs');

        $directory = $this->Directories->get($data[$this->entityKey]);

        $result = $this->Directories->populate($directory);

        if (!$result) {
            throw new QueueException('Directory Process Failed.');
        }

        $job = $this->QueuedJobs->get($jobId);
        $data = array_merge($data, $result);
        $job->set('data', serialize($data));
        $this->QueuedJobs->save($job);
    }
}

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
 * @property \App\Model\Table\DocumentVersionsTable $DocumentVersions
 * @property \Queue\Model\Table\QueuedJobsTable $QueuedJobs
 */
class QueueCompassTask extends QueueTask implements QueueTaskInterface
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
     * @param array $data The array passed to QueuedJobsTable::createJob()
     * @param int $jobId The id of the QueuedJob entity
     * @return void
     */
    public function run(array $data, $jobId): void
    {
        if (!key_exists('version', $data)) {
            throw new QueueException('Document Version Number not specified.');
        }

        $this->loadModel('DocumentVersions');
        $this->loadModel('Queue.QueuedJobs');

        $version = $this->DocumentVersions->get($data['version']);

        $result = $this->DocumentVersions->importCompassRecords($version);

        if (!$result) {
            throw new QueueException('Compass Import Failed.');
        }

        $job = $this->QueuedJobs->get($jobId);
        $data['records'] = $result;
        $job->set('data', serialize($data));
        $this->QueuedJobs->save($job);
    }
}

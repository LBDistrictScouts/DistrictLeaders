<?php
declare(strict_types=1);

namespace App\Shell\Task;

use Cake\Utility\Inflector;
use Queue\Model\QueueException;

/**
 * Class QueueTask
 *
 * @package App\Shell\Task
 */
trait JobDataTrait
{
    /**
     * @var \Queue\Model\Table\QueuedJobsTable
     */
    public $QueuedJobs;

    /**
     * @var string The access key for job data
     */
    protected $dataKey = 'data';

    /**
     * @param int $jobId The ID of the Job
     * @param array $result The data array to be written
     * @return void
     */
    protected function saveJobDataArray(int $jobId, array $result): void
    {
        if (empty($jobId)) {
            throw new QueueException('Job ID is not set.');
        }

        $job = $this->QueuedJobs->get($jobId);
        if (!empty($job->data)) {
            $data = unserialize($job->data);
            $data = array_merge($data, $result);
        } else {
            $data = $result;
        }

        $job->set($this->dataKey, serialize($data));
        $this->QueuedJobs->save($job);
    }

    /**
     * @param int $jobId The ID of the Job
     * @param string|int $result The result Output
     * @param string $key The data key
     * @return void
     */
    protected function saveJobResult(int $jobId, $result, string $key): void
    {
        if (empty($key)) {
            throw new QueueException('Output Key is not set.');
        }

        $this->saveJobDataArray($jobId, [$key => $result]);
    }

    /**
     * @param array $data Data for Entity Check
     * @return void
     */
    protected function checkEntityKey(array $data): void
    {
        if (!empty($this->entityKey)) {
            $message = ucwords(Inflector::humanize($this->entityKey)) . ' not specified.';

            if (!key_exists($this->entityKey, $data)) {
                throw new QueueException($message);
            }
        }
    }
}

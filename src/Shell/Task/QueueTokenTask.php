<?php
declare(strict_types=1);

namespace App\Shell\Task;

use Queue\Shell\Task\QueueTask;
use Queue\Shell\Task\QueueTaskInterface;

/**
 * Class QueueWelcomeTask
 *
 * @package App\Shell\Task
 * @property \App\Model\Table\TokensTable $Tokens
 */
class QueueTokenTask extends QueueTask implements QueueTaskInterface
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

    /**
     * @param array $data The array passed to QueuedJobsTable::createJob()
     * @param int $jobId The id of the QueuedJob entity
     * @return void
     */
    public function run(array $data, $jobId): void
    {
        $this->loadModel('Tokens');
        $result = $this->Tokens->cleanAllTokens((int)$jobId);
        $this->saveJobDataArray((int)$jobId, $result);
    }
}

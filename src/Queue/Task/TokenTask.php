<?php
declare(strict_types=1);

namespace App\Queue\Task;

use App\Model\Table\TokensTable;
use Queue\Queue\Task;
use Queue\Queue\TaskInterface;

/**
 * Class QueueWelcomeTask
 *
 * @package App\Shell\Task
 * @property TokensTable $Tokens
 */
class TokenTask extends Task implements TaskInterface
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

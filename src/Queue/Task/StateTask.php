<?php

declare(strict_types=1);

namespace App\Queue\Task;

use App\Model\Table\UsersTable;
use App\Model\Table\UserStatesTable;
use Queue\Model\Table\QueuedJobsTable;
use Queue\Queue\Task;
use Queue\Queue\TaskInterface;

/**
 * Class QueueWelcomeTask
 *
 * @package App\Shell\Task
 * @property UsersTable $Users
 * @property UserStatesTable $UserStates
 * @property QueuedJobsTable $QueuedJobs
 */
class StateTask extends Task implements TaskInterface
{
    use JobDataTrait;

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
    private $outputKey = 'user_records';

    /**
     * @param array $data The array passed to QueuedJobsTable::createJob()
     * @param int $jobId The id of the QueuedJob entity
     * @return void
     */
    public function run(array $data, $jobId): void
    {
        $this->jobId = $jobId;

        $this->loadModel('UserStates');
        $this->loadModel('Users');

        $users = $this->Users->find('all');
        $total = $users->count();
        $current = 0;

        foreach ($users as $user) {
            $this->UserStates->handleUserState($user);

            $current++;
            $this->QueuedJobs->updateProgress($jobId, $current / $total);
        }

        $this->saveJobResult((int)$jobId, $current, $this->outputKey);
    }
}

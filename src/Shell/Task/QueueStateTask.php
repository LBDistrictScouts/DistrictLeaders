<?php
declare(strict_types=1);

namespace App\Shell\Task;

use Queue\Shell\Task\QueueTask;
use Queue\Shell\Task\QueueTaskInterface;

/**
 * Class QueueWelcomeTask
 *
 * @package App\Shell\Task
 * @property \App\Model\Table\UsersTable $Users
 * @property \App\Model\Table\UserStatesTable $UserStates
 * @property \Queue\Model\Table\QueuedJobsTable $QueuedJobs
 */
class QueueStateTask extends QueueTask implements QueueTaskInterface
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
    private $outputKey = 'user_records';

    /**
     * @param array $data The array passed to QueuedJobsTable::createJob()
     * @param int $jobId The id of the QueuedJob entity
     * @return void
     */
    public function run(array $data, $jobId): void
    {
        $this->loadModel('UserStates');
        $this->loadModel('Users');
        $this->loadModel('Queue.QueuedJobs');

        $users = $this->Users->find('all');
        $total = $users->count();
        $current = 0;

        foreach ($users as $user) {
            $this->UserStates->handleUserState($user);

            $current++;
            $this->QueuedJobs->updateProgress($jobId, $current / $total);
        }

        $job = $this->QueuedJobs->get($jobId);
        $data[$this->outputKey] = $current;
        $job->set('data', serialize($data));
        $this->QueuedJobs->save($job);
    }
}

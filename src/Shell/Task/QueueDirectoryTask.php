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
 */
class QueueDirectoryTask extends QueueTask implements QueueTaskInterface
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
    private $entityKey = 'directory';

    /**
     * @param array $data The array passed to QueuedJobsTable::createJob()
     * @param int $jobId The id of the QueuedJob entity
     * @return void
     */
    public function run(array $data, $jobId): void
    {
        $this->checkEntityKey($data);

        $this->loadModel('Directories');

        $directory = $this->Directories->get($data[$this->entityKey]);

        $result = $this->Directories->populate($directory);

        if (!$result) {
            throw new QueueException('Directory Process Failed.');
        }

        $this->saveJobDataArray((int)$jobId, $result);
    }
}

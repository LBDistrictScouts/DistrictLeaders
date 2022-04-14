<?php
declare(strict_types=1);

namespace App\Queue\Task;

use App\Model\Table\DirectoriesTable;
use Queue\Model\QueueException;
use Queue\Queue\Task;
use Queue\Queue\TaskInterface;

/**
 * Class QueueWelcomeTask
 *
 * @package App\Shell\Task
 * @property DirectoriesTable $Directories
 */
class DirectoryTask extends Task implements TaskInterface
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
    private string $entityKey = 'directory';

    /**
     * @param array $data The array passed to QueuedJobsTable::createJob()
     * @param int $jobId The id of the QueuedJob entity
     * @return void
     */
    public function run(array $data, int $jobId): void
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

<?php
declare(strict_types=1);

namespace App\Queue\Task;

use App\Model\Entity\DocumentVersion;
use Queue\Model\QueueException;
use Queue\Queue\Task;
use Queue\Queue\TaskInterface;

/**
 * Class QueueWelcomeTask
 *
 * @package App\Shell\Task
 * @property \App\Model\Table\CompassRecordsTable $CompassRecords
 * @property \App\Model\Table\DocumentVersionsTable $DocumentVersions
 */
class AutoMergeTask extends Task implements TaskInterface
{
    use JobDataTrait;

    /**
     * @var int
     */
    public int $timeout = 900;

    /**
     * @var int
     */
    public int $retries = 1;

    /**
     * @var string The Data Key
     */
    protected string $entityKey = 'version';

    /**
     * @param array $data The array passed to QueuedJobsTable::createJob()
     * @param int $jobId The id of the QueuedJob entity
     * @return void
     */
    public function run(array $data, int $jobId): void
    {
        $this->loadModel('DocumentVersions');
        $this->loadModel('CompassRecords');

        $this->checkEntityKey($data);

        $version = $this->DocumentVersions->get($data[$this->entityKey]);

        if (!($version instanceof DocumentVersion)) {
            throw new QueueException('Invalid Document Version ID.');
        }

        $result = $this->CompassRecords->autoMerge($version);

        if (!$result) {
            throw new QueueException('Compass Import Failed.');
        }

        $this->saveJobDataArray((int)$jobId, $result);
    }
}

<?php
declare(strict_types=1);

namespace App\Shell\Task;

use App\Model\Entity\DocumentVersion;
use Queue\Model\QueueException;
use Queue\Shell\Task\QueueTask;
use Queue\Shell\Task\QueueTaskInterface;

/**
 * Class QueueWelcomeTask
 *
 * @package App\Shell\Task
 * @property \App\Model\Table\CompassRecordsTable $CompassRecords
 * @property \App\Model\Table\DocumentVersionsTable $DocumentVersions
 */
class QueueAutoMergeTask extends QueueTask implements QueueTaskInterface
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
    protected $entityKey = 'version';

    /**
     * @param array $data The array passed to QueuedJobsTable::createJob()
     * @param int $jobId The id of the QueuedJob entity
     * @return void
     */
    public function run(array $data, $jobId): void
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

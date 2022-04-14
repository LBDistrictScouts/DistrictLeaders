<?php
declare(strict_types=1);

namespace App\Queue\Task;

use Queue\Model\QueueException;
use Queue\Queue\Task;
use Queue\Queue\TaskInterface;

/**
 * Class QueueWelcomeTask
 *
 * @package App\Shell\Task
 * @property \App\Model\Table\DocumentVersionsTable $DocumentVersions
 */
class CompassTask extends Task implements TaskInterface
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
     * @var string The Data Key
     */
    protected $outputKey = 'compass_records';

    /**
     * @param array $data The array passed to QueuedJobsTable::createJob()
     * @param int $jobId The id of the QueuedJob entity
     * @return void
     */
    public function run(array $data, $jobId): void
    {
        $this->loadModel('DocumentVersions');

        $this->checkEntityKey($data);

        $version = $this->DocumentVersions->get($data[$this->entityKey]);

        $result = $this->DocumentVersions->importCompassRecords($version);

        if (!$result) {
            throw new QueueException('Compass Import Failed.');
        }

        $this->saveJobResult((int)$jobId, $result, $this->outputKey);
    }
}

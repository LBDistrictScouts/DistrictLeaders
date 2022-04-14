<?php
declare(strict_types=1);

namespace App\Test\TestCase\Task;

use Cake\TestSuite\TestCase;
use Queue\Model\Entity\QueuedJob;

/**
 * Trait TaskTestTrait
 *
 * @package App\Test\TestCase\Task
 */
trait TaskTestTrait
{
    /**
     * @param array $expected Data to be verified exists
     * @param int $jobId Job for record retrieval
     */
    protected function validateExpectedData(array $expected, int $jobId)
    {
        $job = $this->QueuedJobs->get($jobId);
        $data = unserialize($job->get('data'));

        TestCase::assertIsArray($data);
        TestCase::assertEquals($expected, $data);
    }

    /**
     * @param string $taskName Name of the Task Type
     * @param array $inputData Passed input Data
     * @return QueuedJob
     */
    protected function checkCreateJob(string $taskName, array $inputData = []): QueuedJob
    {
        $originalJobCount = $this->QueuedJobs->find('all')->count();
        TestCase::assertEquals(0, $originalJobCount);

        $job = $this->QueuedJobs->createJob(
            $taskName,
            $inputData
        );

        $resultingJobCount = $this->QueuedJobs->find('all')->count();

        TestCase::assertNotEquals($originalJobCount, $resultingJobCount);
        TestCase::assertEquals($originalJobCount + 1, $resultingJobCount);

        TestCase::assertInstanceOf(QueuedJob::class, $job);

        return $job;
    }
}

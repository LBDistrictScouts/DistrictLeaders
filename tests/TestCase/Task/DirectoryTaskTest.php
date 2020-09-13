<?php
declare(strict_types=1);

namespace App\Test\TestCase\Task;

use App\Test\TestCase\QueueTestCase as TestCase;

/**
 * App\Mailer\BasicMailer Test Case
 */
class DirectoryTaskTest extends TestCase
{
    /**
     * Test initial setup
     *
     * @return void
     */
    public function testEmailQueueJob()
    {
        $this->markTestIncomplete();

        $originalJobCount = $this->QueuedJobs->find('all')->count();
        TestCase::assertEquals(0, $originalJobCount);

        $this->QueuedJobs->createJob(
            'Email',
            ['email_generation_code' => 'USR-2-NEW']
        );

        $resultingJobCount = $this->QueuedJobs->find('all')->count();

        TestCase::assertNotEquals($originalJobCount, $resultingJobCount);
        TestCase::assertEquals($originalJobCount + 1, $resultingJobCount);

        /** @var \Queue\Model\Entity\QueuedJob $job */
        $job = $this->QueuedJobs->find()->first();
        $data = unserialize($job->get('data'));

        $this->Task->run($data, $job->id);
    }

    public function provideQueueException(): array
    {
        return [
            'Email Code Missing' => [
                [],
                'Email generation code not specified.',
                'Queue\Model\QueueException',
            ],
            'Primary Key Missing' => [
                ['email_generation_code' => ''],
                'Record not found in table "users" with primary key [NULL]',
                'Cake\Datasource\Exception\InvalidPrimaryKeyException',
            ],
            'Make Failure' => [
                ['email_generation_code' => 'BOW-2-'],
                'Make Failed.',
                'Queue\Model\QueueException',
            ],
        ];
    }

    /**
     * Test initial setup
     *
     * @dataProvider provideQueueException
     * @param array $dataArray Data to be passed to job
     * @param string $exceptionExpected Exception message expected
     * @param string $exceptionClass The Class of the Exception
     * @return void
     */
    public function testEmailQueueJobCodeException(array $dataArray, string $exceptionExpected, string $exceptionClass)
    {
        $this->markTestIncomplete();

        $originalJobCount = $this->QueuedJobs->find('all')->count();
        TestCase::assertEquals(0, $originalJobCount);

        $this->QueuedJobs->createJob(
            'Email',
            $dataArray
        );

        $resultingJobCount = $this->QueuedJobs->find('all')->count();

        TestCase::assertNotEquals($originalJobCount, $resultingJobCount);
        TestCase::assertEquals($originalJobCount + 1, $resultingJobCount);

        /** @var \Queue\Model\Entity\QueuedJob $job */
        $job = $this->QueuedJobs->find()->first();
        $data = unserialize($job->get('data'));

        $this->expectExceptionMessage($exceptionExpected);
        $this->expectException($exceptionClass);
        $this->Task->run($data, $job->id);
    }
}

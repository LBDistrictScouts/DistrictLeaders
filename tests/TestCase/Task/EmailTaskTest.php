<?php
declare(strict_types=1);

namespace App\Test\TestCase\Task;

use App\Shell\Task\QueueEmailTask;
use App\Test\TestCase\QueueTestCase as TestCase;
use Cake\Console\ConsoleIo;

/**
 * App\Mailer\BasicMailer Test Case
 */
class EmailTaskTest extends TestCase
{
    use TaskTestTrait;

    /**
     * Setup Defaults
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $testIo = new ConsoleIo($this->out, $this->err);
        $this->Task = new QueueEmailTask($testIo);
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testEmailQueueJob()
    {
        $job = $this->checkCreateJob('Email', ['email_generation_code' => 'USR-2-NEW']);
        $data = unserialize($job->get('data'));

        $this->Task->run($data, $job->id);
        $this->validateExpectedData([
            'email_generation_code' => 'USR-2-NEW',
            'email_send_id' => 3,
        ], $job->id);
    }

    public function provideQueueException(): array
    {
        return [
            'Email Code Missing' => [
                [],
                'Email Generation Code not specified.',
                'Queue\Model\QueueException',
            ],
            'Primary Key Missing' => [
                ['email_generation_code' => ''],
                'Record not found in table "users" with primary key [NULL]',
                'Cake\Datasource\Exception\InvalidPrimaryKeyException',
            ],
//            'Make Failure' => [
//                ['email_generation_code' => 'BOW-2-'],
//                'Make Failed.',
//                'Queue\Model\QueueException',
//            ],
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

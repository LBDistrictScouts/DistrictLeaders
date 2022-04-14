<?php
declare(strict_types=1);

namespace App\Test\TestCase\Task;

use App\Model\Entity\Token;
use App\Model\Table\TokensTable;
use App\Queue\Task\TokenTask;
use App\Test\TestCase\QueueTestCase as TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Queue\Model\Entity\QueuedJob;

/**
 * App\Mailer\BasicMailer Test Case
 *
 * @property TokensTable $Tokens
 */
class TokenTaskTest extends TestCase
{
    use TaskTestTrait;

    /**
     * @var TokenTask|MockObject
     */
    protected $Task;

    /**
     * Setup Defaults
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->Task = new TokenTask();
    }

    /**
     * Test initial setup
     *
     * @return void
     * @throws \Throwable
     */
    public function testTokenQueueJob()
    {
        $this->Tokens = $this->getTableLocator()->get('Tokens');
        $token = $this->Tokens->get(1);

        $token->set(Token::FIELD_ACTIVE, true);
        TestCase::assertInstanceOf(Token::class, $this->Tokens->save($token));

        $job = $this->checkCreateJob('Token');
        $data = unserialize($job->get('data'));

        $this->Task->run($data, $job->id);

        /** @var QueuedJob $job */
        $job = $this->QueuedJobs->find('all')->orderDesc('created')->first();

        TestCase::assertEquals(1, $job->progress);
        $this->validateExpectedData([
            'records' => 1,
            'unchanged' => 1,
            'deactivated' => 0,
            'deleted' => 0,
        ], $job->id);
    }
}

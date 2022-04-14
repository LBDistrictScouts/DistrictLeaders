<?php
declare(strict_types=1);

namespace App\Test\TestCase\Task;

use App\Model\Entity\Token;
use App\Queue\Task\TokenTask;
use App\Test\TestCase\QueueTestCase as TestCase;

/**
 * App\Mailer\BasicMailer Test Case
 *
 * @property \App\Model\Table\TokensTable $Tokens
 */
class TokenTaskTest extends TestCase
{
    use TaskTestTrait;

    /**
     * @var TokenTask|\PHPUnit\Framework\MockObject\MockObject
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

        /** @var \Queue\Model\Entity\QueuedJob $job */
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

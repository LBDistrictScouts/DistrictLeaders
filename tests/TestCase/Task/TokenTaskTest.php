<?php
declare(strict_types=1);

namespace App\Test\TestCase\Task;

use App\Model\Entity\Token;
use App\Shell\Task\QueueTokenTask;
use App\Test\TestCase\QueueTestCase as TestCase;
use Cake\Console\ConsoleIo;

/**
 * App\Mailer\BasicMailer Test Case
 *
 * @property \App\Model\Table\TokensTable $Tokens
 */
class TokenTaskTest extends TestCase
{
    use TaskTestTrait;

    /**
     * @var QueueTokenTask|\PHPUnit\Framework\MockObject\MockObject
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

        $testIo = new ConsoleIo($this->out, $this->err);

        $this->Task = new QueueTokenTask($testIo);
    }

    /**
     * Test initial setup
     *
     * @return void
     * @throws \Throwable
     */
    public function testTokenQueueJob()
    {
        $this->markAsRisky();
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
            'unchanged' => 0,
            'deactivated' => 1,
            'deleted' => 0,
        ], $job->id);
    }
}

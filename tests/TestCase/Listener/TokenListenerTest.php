<?php
declare(strict_types=1);

namespace App\Test\TestCase\Listener;

use App\Listener\TokenListener;
use App\Model\Entity\Token;
use App\Test\TestCase\ControllerTestCase as TestCase;
use Cake\Event\Event;
use Cake\Event\EventList;
use Cake\Event\EventManager;
use Cake\I18n\FrozenTime;

/**
 * Class UserListenerTest
 *
 * @package App\Test\TestCase\Listener
 * @property \App\Model\Table\TokensTable $Tokens
 * @property \Queue\Model\Table\QueuedJobsTable $QueuedJobs
 * @property EventManager $EventManager
 * @property TokenListener $Listener
 */
class TokenListenerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->Tokens = $this->getTableLocator()->get('Tokens');
        $this->QueuedJobs = $this->getTableLocator()->get('Queue.QueuedJobs');

        $this->Listener = new TokenListener();

        // enable event tracking
        $this->EventManager = EventManager::instance();
        $this->EventManager->setEventList(new EventList());

        $now = new FrozenTime('2018-12-25 23:22:30');
        FrozenTime::setTestNow($now);
    }

    public function testEventFired()
    {
        $tokenString = $this->Tokens->buildToken(1);
        $token = $this->Tokens->get(1);
        TestCase::assertIsString($tokenString);

        $now = FrozenTime::getTestNow();
        TestCase::assertNotSame($now, $token->modified);
        TestCase::assertNull($token->utilised);

        $result = $this->Tokens->validateToken($tokenString);
        TestCase::assertEquals(1, $result);
        $this->assertEventFired('Model.Tokens.tokenValidated', $this->EventManager);

        $token = $this->Tokens->get(1);
        TestCase::assertInstanceOf(FrozenTime::class, $token->utilised);

        TestCase::assertTrue($token->get(Token::FIELD_ACTIVE));
        $cleanState = $this->Tokens->cleanToken($token);
        TestCase::assertEquals(1, $cleanState);
    }

    public function testListenerFunctionValid()
    {
        $beforeToken = $this->Tokens->get(1);
        TestCase::assertNull($beforeToken->get($beforeToken::FIELD_UTILISED));

        $fakeEvent = $this
            ->getMockBuilder(Event::class)
            ->setConstructorArgs([
                'Model.Tokens.tokenValidated',
                $this->Tokens,
                ['tokenId' => $beforeToken->id],
            ])
            ->getMock();

        $fakeEvent
            ->expects(TestCase::any())
            ->method('getSubject')
            ->willReturn($this->Tokens);

        $fakeEvent
            ->expects(TestCase::any())
            ->method('getData')
            ->willReturn(1);

        $this->Listener->tokenValidate($fakeEvent);

        $afterToken = $this->Tokens->get(1);
        TestCase::assertNotSame(
            $beforeToken->get($beforeToken::FIELD_UTILISED),
            $afterToken->get($afterToken::FIELD_UTILISED)
        );

        $jobs = $this->QueuedJobs->find();
        TestCase::assertSame(1, $jobs->count());

        $job = $jobs->first();
        TestCase::assertSame('Token', $job->get('job_type'));
        TestCase::assertNull($job->get('data'));
    }
}

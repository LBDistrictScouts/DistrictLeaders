<?php
declare(strict_types=1);

namespace App\Listener;

use App\Model\Entity\Token;
use App\Model\Table\TokensTable;
use Cake\Event\EventInterface;
use Cake\Event\EventListenerInterface;
use Cake\I18n\FrozenTime;
use Cake\ORM\Locator\LocatorAwareTrait;
use Queue\Model\Table\QueuedJobsTable;

/**
 * Class LoginEvent
 *
 * @package App\Listener
 * @property TokensTable $Tokens
 * @property QueuedJobsTable $QueuedJobs
 */
class TokenListener implements EventListenerInterface
{
    use LocatorAwareTrait;

    /**
     * @return array
     */
    public function implementedEvents(): array
    {
        return [
            'Model.Tokens.tokenValidated' => 'tokenValidate',
        ];
    }

    /**
     * @param EventInterface $event The event being processed.
     * @return void
     */
    public function tokenValidate(EventInterface $event): void
    {
        $this->QueuedJobs = $this->getTableLocator()->get('Queue.QueuedJobs');
        $this->Tokens = $event->getSubject();

        $tokenKey = $event->getData('tokenId');
        $token = $this->Tokens->get($tokenKey);

        $token->set(Token::FIELD_UTILISED, FrozenTime::now());
        $this->Tokens->save($token);

        // Dispatch ASync Token Clean Task
        $this->QueuedJobs->createJob('Token');
    }
}

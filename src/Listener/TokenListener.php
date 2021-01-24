<?php
declare(strict_types=1);

namespace App\Listener;

use App\Model\Entity\Token;
use Cake\Event\EventInterface;
use Cake\Event\EventListenerInterface;
use Cake\I18n\FrozenTime;
use Cake\ORM\Locator\LocatorAwareTrait;

/**
 * Class LoginEvent
 *
 * @package App\Listener
 * @property \App\Model\Table\TokensTable $Tokens
 * @property \Queue\Model\Table\QueuedJobsTable $QueuedJobs
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
     * @param \Cake\Event\EventInterface $event The event being processed.
     * @return void
     */
    public function tokenValidate(EventInterface $event): void
    {
        $this->QueuedJobs = $this->getTableLocator()->get('Queue.QueuedJobs');

        /** @var \App\Model\Entity\Token $token */
        $token = $event->getData('token');
        $this->Tokens = $this->getTableLocator()->get('Tokens');

        $token->set(Token::FIELD_UTILISED, FrozenTime::now());
        $this->Tokens->save($token);

        // Dispatch ASync Token Clean Task
        $this->QueuedJobs->createJob('Token');
    }
}

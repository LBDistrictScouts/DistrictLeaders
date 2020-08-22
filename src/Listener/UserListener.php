<?php
declare(strict_types=1);

namespace App\Listener;

use Cake\Cache\Cache;
use Cake\Event\EventListenerInterface;
use Cake\I18n\FrozenTime;
use Cake\ORM\Locator\LocatorAwareTrait;

/**
 * Class LoginEvent
 *
 * @package App\Listener
 * @property \App\Model\Table\UsersTable $Users
 * @property \Queue\Model\Table\QueuedJobsTable $QueuedJobs
 */
class UserListener implements EventListenerInterface
{
    use LocatorAwareTrait;

    /**
     * @return array
     */
    public function implementedEvents(): array
    {
        return [
            'Model.Users.login' => 'updateLogin',
            'Model.Users.capabilityChange' => 'capChange',
        ];
    }

    /**
     * @param \Cake\Event\Event $event The event being processed.
     * @return void
     */
    public function updateLogin($event)
    {
        /** @var \App\Model\Entity\User $user */
        $user = $event->getData('user');
        $this->Users = $this->getTableLocator()->get('Users');

        $user->set('last_login', FrozenTime::now());
        $user->setDirty('modified', true);

        $cacheKeys = [
            'nav_' . $user->get('id'),
            'profile_modal_' . $user->get('id'),
        ];
        Cache::deleteMany($cacheKeys, 'cell_cache');

        $this->Users->save($user);

        $this->Users->patchCapabilities($user);
    }

    /**
     * @param \Cake\Event\Event $event The event being processed.
     * @return void
     */
    public function capChange($event)
    {
        /** @var \App\Model\Entity\User $user */
        $user = $event->getData('user');

        // Dispatch ASync Notification Task
        $this->QueuedJobs = $this->getTableLocator()->get('Queue.QueuedJobs');
        $this->QueuedJobs->createJob(
            'Email',
            ['email_generation_code' => 'USR-' . $user->id . '-CCH']
        );
    }
}

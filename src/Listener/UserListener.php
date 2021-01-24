<?php
declare(strict_types=1);

namespace App\Listener;

use App\Model\Entity\User;
use Cake\Cache\Cache;
use Cake\Event\EventInterface;
use Cake\Event\EventListenerInterface;
use Cake\I18n\FrozenTime;
use Cake\Log\Log;
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
        ];
    }

    /**
     * @param \Cake\Event\EventInterface $event The event being processed.
     * @return void
     */
    public function updateLogin(EventInterface $event): void
    {
        /** @var \App\Model\Entity\User $user */
        $user = $event->getData('user');
        $this->Users = $this->getTableLocator()->get('Users');

        $user->set(User::FIELD_LAST_LOGIN, FrozenTime::now());
        $user->setDirty(User::FIELD_MODIFIED, true);
        if (!$this->Users->save($user)) {
            Log::warning(_('User login time was not saved. For User ID {0}, {1}', (string)$user->id, $user->full_name));
        }

        $cacheKeys = [
            'nav_' . $user->get('id'),
            'profile_modal_' . $user->get('id'),
        ];
        Cache::deleteMany($cacheKeys, 'cell_cache');

        $this->Users->patchCapabilities($user);
    }
}

<?php
declare(strict_types=1);

namespace App\Listener;

use Cake\Event\EventInterface;
use Cake\Event\EventListenerInterface;
use Cake\I18n\Time;
use Cake\ORM\Locator\LocatorAwareTrait;

/**
 * Class LoginEvent
 *
 * @package App\Listener
 * @property \App\Model\Table\UsersTable $Users
 * @property \Queue\Model\Table\QueuedJobsTable $QueuedJobs
 */
class RoleListener implements EventListenerInterface
{
    use LocatorAwareTrait;

    /**
     * @return array
     */
    public function implementedEvents(): array
    {
        return [
            'Model.Roles.roleAdded' => 'newRole',
            'Model.Roles.roleUpdated' => 'roleChange',
            'Model.Roles.newAudits' => 'roleChange',
        ];
    }

    /**
     * @param \Cake\Event\EventInterface $event The event being processed.
     * @return void
     */
    public function newRole(EventInterface $event): void
    {
        /** @var \App\Model\Entity\Role $role */
        $role = $event->getData('entity');

        $this->QueuedJobs = $this->getTableLocator()->get('Queue.QueuedJobs');
        $this->QueuedJobs->createJob(
            'Email',
            ['email_generation_code' => 'ROL-' . $role->id . '-NEW']
        );
    }

    /**
     * @param \Cake\Event\EventInterface $event The event being processed.
     * @return void
     */
    public function roleChange(EventInterface $event): void
    {
        /** @var \App\Model\Entity\Role $role */
        $role = $event->getData('entity');

        $now = Time::now();
        $daysSinceChange = $now->diffInDays($role->modified);

        if ($daysSinceChange > 10) {
            $this->QueuedJobs = $this->getTableLocator()->get('Queue.QueuedJobs');
            $this->QueuedJobs->createJob(
                'Email',
                ['email_generation_code' => 'ROL-' . $role->id . '-CNG']
            );
        }
    }
}

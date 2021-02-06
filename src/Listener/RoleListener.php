<?php
declare(strict_types=1);

namespace App\Listener;

use App\Model\Table\RolesTable;
use Cake\Event\EventInterface;
use Cake\Event\EventListenerInterface;
use Cake\I18n\Time;
use Cake\Log\Log;
use Cake\ORM\Locator\LocatorAwareTrait;

/**
 * Class LoginEvent
 *
 * @package App\Listener
 * @property \App\Model\Table\RolesTable $Roles
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
        $roleId = $event->getData('roleId');

        $this->QueuedJobs = $this->getTableLocator()->get('Queue.QueuedJobs');
        $this->QueuedJobs->createJob(
            'Email',
            ['email_generation_code' => 'ROL-' . $roleId . '-NEW']
        );
    }

    /**
     * @param \Cake\Event\EventInterface $event The event being processed.
     * @return void
     */
    public function roleChange(EventInterface $event): void
    {
        $roleId = $event->getData('roleId');
        $this->Roles = $event->getSubject();
        if (!$this->Roles instanceof RolesTable) {
            Log::warning('Event called with incorrect subject');

            return;
        }

        if (!$this->Roles->exists(['id' => $roleId])) {
            Log::warning('Event called with incorrect data, role ID does not exist');

            return;
        }

        $role = $this->Roles->get($roleId);

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

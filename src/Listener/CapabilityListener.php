<?php
declare(strict_types=1);

namespace App\Listener;

use App\Model\Entity\RoleTemplate;
use Cake\Event\EventInterface;
use Cake\Event\EventListenerInterface;
use Cake\ORM\Locator\LocatorAwareTrait;
use Queue\Model\Table\QueuedJobsTable;

/**
 * Class LoginEvent
 *
 * @package App\Listener
 */
class CapabilityListener implements EventListenerInterface
{
    use LocatorAwareTrait;

    /**
     * @return array
     */
    public function implementedEvents(): array
    {
        return [
            'Model.RoleTemplates.templateChange' => 'templateChange',
        ];
    }

    /**
     * @param EventInterface $event The event being processed.
     * @return void
     */
    public function templateChange(EventInterface $event)
    {
        /** @var QueuedJobsTable $QueuedJobs */
        $QueuedJobs = $this->getTableLocator()->get('Queue.QueuedJobs');

        /** @var RoleTemplate $roleTemplate */
        $roleTemplate = $event->getData('role_template');

        $QueuedJobs = $this->getTableLocator()->get('Queue.QueuedJobs');
        $QueuedJobs->createJob(
            'Capability',
            ['role_template_id' => $roleTemplate->id]
        );
    }
}

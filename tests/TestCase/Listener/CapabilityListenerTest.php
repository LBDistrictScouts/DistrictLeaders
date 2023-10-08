<?php
declare(strict_types=1);

namespace App\Test\TestCase\Listener;

use App\Model\Entity\RoleTemplate;
use App\Test\TestCase\ControllerTestCase as TestCase;
use Cake\Event\EventList;
use Cake\Event\EventManager;
use Queue\Model\Entity\QueuedJob;

/**
 * Class UserListenerTest
 *
 * @package App\Test\TestCase\Listener
 * @property RoleTemplatesTable $RoleTemplates
 * @property EventManager $EventManager
 */
class CapabilityListenerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->RoleTemplates = $this->getTableLocator()->get('RoleTemplates');

        // enable event tracking
        $this->EventManager = EventManager::instance();
        $this->EventManager->setEventList(new EventList());
    }

    public function testEventFired()
    {
        $roleTemplate = $this->RoleTemplates->get(1);
        $roleTemplate->set(RoleTemplate::FIELD_TEMPLATE_CAPABILITIES, ['LOGIN']);

        TestCase::assertNotFalse($this->RoleTemplates->save($roleTemplate));

        $this->assertEventFired('Model.RoleTemplates.templateChange', $this->EventManager);
    }

    public function testQueueCreated()
    {
        $this->markTestIncomplete();

        $roleTemplate = $this->RoleTemplates->get(1);
        $roleTemplate->set(RoleTemplate::FIELD_TEMPLATE_CAPABILITIES, ['LOGIN']);

        TestCase::assertNotFalse($this->RoleTemplates->save($roleTemplate));

        $this->assertEventFired('Model.RoleTemplates.templateChange', $this->EventManager);

        $job = $this->QueuedJobs->find()->orderDesc('created')->first();
        TestCase::assertInstanceOf(QueuedJob::class, $job);

        $data = unserialize($job->get('data'));
        TestCase::assertEquals(['role_template_id' => 1], $data);
    }
}

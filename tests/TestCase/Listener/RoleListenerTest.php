<?php
declare(strict_types=1);

namespace App\Test\TestCase\Listener;

use App\Model\Entity\Role;
use App\Test\TestCase\ControllerTestCase as TestCase;
use Cake\Event\EventList;
use Cake\Event\EventManager;

/**
 * Class UserListenerTest
 *
 * @package App\Test\TestCase\Listener
 * @property \App\Model\Table\RolesTable $Roles
 * @property EventManager $EventManager
 */
class RoleListenerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->Roles = $this->getTableLocator()->get('Roles');
        $this->QueuedJobs = $this->getTableLocator()->get('Queue.QueuedJobs');

        // enable event tracking
        $this->EventManager = EventManager::instance();
        $this->EventManager->setEventList(new EventList());
    }

    public function testNewRoleAdded()
    {
        $role = $this->Roles->newEntity([
            'role_type_id' => 6,
            'section_id' => 1,
            'user_id' => 2,
            'role_status_id' => 1,
            'created' => 1545697703,
            'modified' => 1545697703,
            'deleted' => null,
            'user_contact_id' => 1,
        ]);

        $role = $this->Roles->save($role);
        TestCase::assertInstanceOf(Role::class, $role);

        $this->assertEventFired('Model.Roles.roleAdded', $this->EventManager);

        /*$jobs = $this->QueuedJobs->find()->orderDesc('created');
        TestCase::assertEquals(1, $jobs->count());

        $job = $jobs->first();
        $expected = ['email_generation_code' => 'ROL-' . $role->id . '-NEW'];
        TestCase::assertEquals($expected, unserialize($job->get('data')));*/
    }

    public function testNewRoleChanged()
    {
        $role = $this->Roles->get(1);

        $role->set(Role::FIELD_ROLE_TYPE_ID, $role->role_type_id + 1);
        $role = $this->Roles->save($role);
        TestCase::assertInstanceOf(Role::class, $role);

        $this->assertEventFired('Model.Roles.roleUpdated', $this->EventManager);

        /*$jobs = $this->QueuedJobs->find()->orderDesc('created');
        TestCase::assertEquals(1, $jobs->count());

        $job = $jobs->first();
        $expected = ['email_generation_code' => 'ROL-' . $role->id . '-CNG'];
        TestCase::assertEquals($expected, unserialize($job->get('data')));*/
    }
}

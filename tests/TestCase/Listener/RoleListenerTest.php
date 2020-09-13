<?php
declare(strict_types=1);

namespace App\Test\TestCase\Listener;

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

        TestCase::assertNotFalse($this->Roles->save($role));

        $this->assertEventFired('Model.Roles.roleAdded', $this->EventManager);
    }
}

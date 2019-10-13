<?php


namespace App\Test\TestCase\Listener;

//use App\Model\Table\OrdersTable;
use App\Model\Entity\Role;
use App\Test\TestCase\Controller\AppTestTrait;
use Cake\Event\EventList;
use Cake\Event\EventManager;
use Cake\I18n\FrozenTime;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Class UserListenerTest
 *
 * @package App\Test\TestCase\Listener
 *
 * @property \App\Model\Table\RolesTable $Roles
 * @property EventManager $EventManager
 */
class RoleListenerTest extends TestCase
{
    use AppTestTrait;

    public $fixtures = [
        'app.PasswordStates',
        'app.Users',
        'app.CapabilitiesRoleTypes',
        'app.Capabilities',
        'app.ScoutGroups',
        'app.SectionTypes',
        'app.RoleTypes',
        'app.RoleStatuses',
        'app.Sections',
        'app.Audits',
        'app.UserContactTypes',
        'app.UserContacts',
        'app.Roles',
    ];

    public function setUp()
    {
        parent::setUp();
        $this->Roles = TableRegistry::getTableLocator()->get('Roles');
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

        $this->assertEventFired('Model.Role.roleAdded', $this->EventManager);
    }
}

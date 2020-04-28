<?php
declare(strict_types=1);

namespace App\Test\TestCase\Listener;

use App\Model\Entity\Role;
use App\Model\Entity\User;
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
 * @property \App\Model\Table\UsersTable $Users
 * @property \App\Model\Table\RolesTable $Roles
 * @property EventManager $EventManager
 * @property EventManager $RoleEvents
 */
class UserListenerTest extends TestCase
{
    use AppTestTrait;

    public $fixtures = [
        'app.UserStates',
        'app.Users',
        'app.CapabilitiesRoleTypes',
        'app.Capabilities',
        'app.ScoutGroups',
        'app.SectionTypes',
        'app.RoleTemplates',
        'app.RoleTypes',
        'app.RoleStatuses',
        'app.Sections',
        'app.Audits',
        'app.UserContactTypes',
        'app.UserContacts',
        'app.Roles',
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->Users = TableRegistry::getTableLocator()->get('Users');
        $this->Roles = TableRegistry::getTableLocator()->get('Roles');

        // enable event tracking
        $this->EventManager = EventManager::instance();
        $this->EventManager->setEventList(new EventList());

        $this->RoleEvents = $this->Roles->getEventManager();
        $this->RoleEvents->setEventList(new EventList());
    }

    public function testUpdateLogin()
    {
        $now = new Time('2018-12-25 23:22:30');
        FrozenTime::setTestNow($now);

        $testPassword = 'ThisTestPassword';
        $user = $this->Users->get(1);

        $user->set(User::FIELD_PASSWORD, $testPassword);
        TestCase::assertNotFalse($this->Users->save($user));

        $now = new Time('2018-12-28 23:22:30');
        FrozenTime::setTestNow($now);

        $redirect = [
            'controller' => 'Pages',
            'action' => 'display',
            'home',
        ];

        $this->tryPost([
            'controller' => 'Users',
            'action' => 'login',
        ], [
            'username' => $user->username,
            'password' => $testPassword,
        ], $redirect);

        $this->assertRedirect($redirect);
        TestCase::assertArrayHasKey('Auth', $this->_session);

        $this->assertEventFired('Model.Users.login', $this->EventManager);

        $afterUser = $this->Users->get(1);

        TestCase::assertEquals($now, $afterUser->last_login);
        TestCase::assertNotEquals($now, $afterUser->modified);
    }

    public function testCapabilityChange()
    {
        $role = $this->Roles->get(1);
        $role->set(Role::FIELD_USER_CONTACT_ID, 2);
        TestCase::assertNotFalse($this->Roles->save($role));

        $this->assertEventFired('Model.Users.capabilityChange', $this->EventManager);
    }
}

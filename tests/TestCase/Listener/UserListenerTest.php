<?php
declare(strict_types=1);

namespace App\Test\TestCase\Listener;

use App\Model\Entity\User;
use App\Test\TestCase\ControllerTestCase as TestCase;
use Cake\Event\EventList;
use Cake\Event\EventManager;
use Cake\I18n\FrozenTime;

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
    public function setUp(): void
    {
        parent::setUp();
        $this->Users = $this->getTableLocator()->get('Users');
        $this->Roles = $this->getTableLocator()->get('Roles');

        // enable event tracking
        $this->EventManager = EventManager::instance();
        $this->EventManager->setEventList(new EventList());

        $this->RoleEvents = $this->Roles->getEventManager();
        $this->RoleEvents->setEventList(new EventList());
    }

    public function testUpdateLogin()
    {
        $now = new FrozenTime('2018-12-25 23:22:30');
        FrozenTime::setTestNow($now);

        $testPassword = 'ThisTestPassword';
        $user = $this->Users->get(1);

        $user->set(User::FIELD_PASSWORD, $testPassword);
        TestCase::assertNotFalse($this->Users->save($user));

        $user = $this->Users->get(1);
        TestCase::assertEquals($now, $user->modified);

        $now = new FrozenTime('2018-12-28 23:22:30');
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
}

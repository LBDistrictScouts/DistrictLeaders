<?php
declare(strict_types=1);

namespace App\Test\TestCase\Listener;

use App\Listener\UserListener;
use App\Model\Entity\User;
use App\Test\TestCase\ControllerTestCase as TestCase;
use Cake\Event\Event;
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
 * @property UserListener $Listener
 */
class UserListenerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->Users = $this->getTableLocator()->get('Users');
        $this->Roles = $this->getTableLocator()->get('Roles');

        $this->Listener = new UserListener();

        // enable event tracking
        $this->EventManager = EventManager::instance();
        $this->EventManager->setEventList(new EventList());

        $this->RoleEvents = $this->Roles->getEventManager();
        $this->RoleEvents->setEventList(new EventList());
    }

    /**
     * @return array
     */
    public function prepare()
    {
        $now = new FrozenTime('2018-12-25 23:22:30');
        FrozenTime::setTestNow($now);

        $testPassword = 'ThisTestPassword';
        $user = $this->Users->get(1);

        $user->set(User::FIELD_PASSWORD, $testPassword);
        TestCase::assertNotFalse($this->Users->save($user));

        $user = $this->Users->get(1);
        TestCase::assertEquals($now, $user->modified);

        return compact('testPassword', 'user');
    }

    public function testEventFired()
    {
        $userSetup = $this->prepare();
        /** @var User $user */
        $user = $userSetup['user'];

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
            'password' => $userSetup['testPassword'],
        ], $redirect);

        $this->assertRedirect($redirect);
        TestCase::assertArrayHasKey('Auth', $this->_session);

        $this->assertEventFired('Model.Users.login', $this->EventManager);

        $afterUser = $this->Users->get(1);

        TestCase::assertEquals($now, $afterUser->last_login);
        TestCase::assertNotEquals($now, $afterUser->modified);
    }

    public function testListenerFunctionValid()
    {
        $setupArray = $this->prepare();
        /** @var User $beforeUser */
        $beforeUser = $setupArray['user'];

        $fakeEvent = $this
            ->getMockBuilder(Event::class)
            ->setConstructorArgs([
                'Model.Users.login',
                $this->Users,
                ['user' => []],
            ])
            ->getMock();

        $fakeEvent
            ->expects(TestCase::any())
            ->method('getData')
            ->willReturn([]);

        $fakeEvent
            ->expects(TestCase::any())
            ->method('getSubject')
            ->willReturn($this->Users);

        $this->Listener->updateLogin($fakeEvent);

        $afterUser = $this->Users->get(1);
        TestCase::assertNotSame(
            $beforeUser->get($beforeUser::FIELD_LAST_LOGIN),
            $afterUser->get($afterUser::FIELD_LAST_LOGIN)
        );
    }
}

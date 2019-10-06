<?php


namespace App\Test\TestCase\Event;

//use App\Model\Table\OrdersTable;
use App\Model\Entity\User;
use App\Test\TestCase\Controller\AppTestTrait;
use Cake\Event\EventList;
use Cake\Event\EventManager;
use Cake\I18n\FrozenTime;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * Class UserEventTest
 *
 * @package App\Test\TestCase\Event
 *
 * @property \App\Model\Table\UsersTable $Users
 * @property EventManager $EventManager
 */
class UserEventTest extends TestCase
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
        $this->Users = TableRegistry::getTableLocator()->get('Users');
        // enable event tracking
        $this->EventManager = EventManager::instance();
        $this->EventManager->setEventList(new EventList());
    }

    public function testUpdateLogin()
    {
        $now = new Time('2018-12-26 23:22:30');
        FrozenTime::setTestNow($now);

        $testPassword = 'ThisTestPassword';

        $this->Users = TableRegistry::getTableLocator()->get('Users');
        $user = $this->Users->get(1);

        $user->set(User::FIELD_PASSWORD, $testPassword);
        TestCase::assertNotFalse($this->Users->save($user));

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

        $this->assertEventFired('Model.User.login', $this->EventManager);

        $afterUser = $this->Users->get(1);

        TestCase::assertEquals($now, $afterUser->last_login);
    }
}

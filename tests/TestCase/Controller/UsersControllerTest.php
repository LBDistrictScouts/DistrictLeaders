<?php
namespace App\Test\TestCase\Controller;

use App\Controller\UsersController;
use App\Model\Entity\User;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\UsersController Test Case
 *
 * @uses \App\Controller\UsersController
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersControllerTest extends TestCase
{
    use AppTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PasswordStates',
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
        'app.CampTypes',
        'app.Camps',
        'app.CampRoleTypes',
        'app.CampRoles',
        'app.Notifications',
        'app.NotificationTypes',
        'app.EmailSends',
        'app.Tokens',
        'app.EmailResponseTypes',
        'app.EmailResponses',
    ];

    /**
     * @var string $controller The Name of the controller being interrogated.
     */
    private $controller = 'Users';

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->tryIndexGet($this->controller);
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->tryViewGet($this->controller);
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->tryAddGet($this->controller);

        $this->tryAddPost(
            $this->controller,
            [
                'membership_number' => '12345',
                'first_name' => 'BOB',
                'last_name' => 'ROBERT',
                'email' => 'bob@4thgoat.org.uk',
                'address_line_1' => 'My House',
                'address_line_2' => '',
                'city' => 'Somewhere',
                'county' => 'Fun',
                'postcode' => 'SG8 1BN',
            ],
            3
        );
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->tryEditGet($this->controller);

        $this->tryEditPost(
            $this->controller,
            [
                'membership_number' => 145921,
                'first_name' => 'Goat',
                'last_name' => 'Fish',
                'email' => 'goat@4thgoat.org.uk',
                'address_line_1' => '47 Goat Ave',
                'address_line_2' => '',
                'city' => 'London',
                'county' => 'Greater London',
                'postcode' => 'PS99 4NG',
            ],
            1
        );
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->tryDeletePost(
            $this->controller,
            [
                'membership_number' => '12345',
                'first_name' => 'BOB',
                'last_name' => 'ROBERT',
                'email' => 'bob@4thgoat.org.uk',
                'address_line_1' => 'My House',
                'address_line_2' => '',
                'city' => 'Somewhere',
                'county' => 'Fun',
                'postcode' => 'SG8 1BN',
            ],
            3
        );
    }

    /**
     * Test login method
     *
     * @return void
     * @throws \PHPUnit\Exception
     */
    public function testLogin()
    {
        $this->get([
            'controller' => 'Users',
            'action' => 'login',
        ]);

        $this->assertResponseContains('Leader Login');
        $this->assertResponseOk();

        // Logging In
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
    }

    /**
     * Test reset method
     *
     * @return void
     */
    public function testReset()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test username method
     *
     * @return void
     */
    public function testUsername()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test token method
     *
     * @return void
     */
    public function testToken()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

<?php
namespace App\Test\TestCase\Model\Entity;

use App\Model\Entity\Capability;
use App\Model\Entity\User;
use App\Test\TestCase\Controller\AppTestTrait;
use Authorization\AuthorizationServiceInterface;
use Authorization\IdentityDecorator;
use Authorization\IdentityInterface;
use Authorization\Middleware\AuthorizationMiddleware;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use InvalidArgumentException;
use Psr\Http\Message\RequestInterface;

/**
 * App\Model\Entity\User Test Case
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UserTest extends TestCase
{
    use AppTestTrait;

    /**
     * Test subject
     *
     * @var \App\Model\Entity\User
     */
    public $User;

    /**
     * Test Table subject
     *
     * @var AuthorizationServiceInterface
     */
    public $Auth;

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
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->User = new User();
        $this->Auth = $this->createMock(AuthorizationServiceInterface::class);

        $this->Users = TableRegistry::getTableLocator()->get('Users');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->User);
        unset($this->Auth);

        parent::tearDown();
    }

    /**
     * Test Constructor Method Fail
     *
     * @return void
     */
    public function testConstructorInvalidData()
    {
        $this->expectException(InvalidArgumentException::class);

        new IdentityDecorator($this->Auth, 'bad');
    }

    /**
     * Test can method
     *
     * @return void
     */
    public function testCan()
    {
        $identity = new IdentityDecorator($this->Auth, ['id' => 1]);

        $this->Auth->expects($this->once())
             ->method('can')
             ->with($identity, 'update', $this->User)
             ->will($this->returnValue(true));

        TestCase::assertTrue($identity->can('update', $this->User));
    }

    /**
     * Test applyScope method
     *
     * @return void
     */
    public function testApplyScope()
    {
        $identity = new IdentityDecorator($this->Auth, ['id' => 1]);

        $this->Auth->expects($this->once())
             ->method('applyScope')
             ->with($identity, 'update', $this->User)
             ->will($this->returnValue(true));

        TestCase::assertTrue($identity->applyScope('update', $this->User));
    }

    /**
     * Test getOriginalData method
     *
     * @return void
     */
    public function testGetOriginalData()
    {
        $data = ['id' => 2];

        $identity = new IdentityDecorator($this->Auth, $data);

        TestCase::assertSame($data, $identity->getOriginalData());
    }

    /**
     * Test setAuthorization method
     *
     * @return void
     */
    public function testSetAuthorization()
    {
        /** @var \App\Model\Entity\User $identity */
        $identity = new User([
            'id' => 1
        ]);
        $this->Auth = $this->createMock(AuthorizationServiceInterface::class);
        $request = (new ServerRequest())->withAttribute('identity', $identity);
        $response = new Response();
        $next = function ($request) {
            return $request;
        };
        $middleware = new AuthorizationMiddleware($this->Auth, [
            'identityDecorator' => function ($service, $identity) {
                $identity->setAuthorization($service);

                return $identity;
            },
            'requireAuthorizationCheck' => false,
        ]);
        $result = $middleware($request, $response, $next);

        TestCase::assertInstanceOf(RequestInterface::class, $result);
        TestCase::assertSame($this->Auth, $result->getAttribute('authorization'));
        TestCase::assertInstanceOf(IdentityInterface::class, $result->getAttribute('identity'));
        TestCase::assertSame($identity, $result->getAttribute('identity'));
    }

    /**
     * Test getIdentifier method
     *
     * @return void
     */
    public function testGetIdentifier()
    {
        $users = TableRegistry::getTableLocator()->get('Users');
        $testUser = $users->get(1);

        TestCase::assertEquals(1, $testUser->getIdentifier());
    }

    /**
     * @param User $user The user to be altered.
     *
     * @return User
     */
    private function notAll($user)
    {
        $roleTypes = TableRegistry::getTableLocator()->get('RoleTypes');
        $superUser = $roleTypes->get(5, ['contain' => ['Capabilities']]);

        $allPermission = $roleTypes->Capabilities->find()->where([Capability::FIELD_CAPABILITY_CODE => 'ALL'])->toList();
        $roleTypes->Capabilities->unlink($superUser, $allPermission);

        $this->Users->patchCapabilities($user);

        return $this->Users->get($user->get(User::FIELD_ID));
    }

    /**
     * Test checkCapability method
     *
     * @return void
     */
    public function testCheckCapability()
    {
        $testUser = $this->Users->get(1);

        $this->Users->patchCapabilities($testUser);
        $testUser = $this->Users->get(1);

        TestCase::assertTrue($testUser->checkCapability('ALL'));

        $this->notAll($testUser);
        TestCase::assertFalse($testUser->checkCapability('ALL'));

        TestCase::assertTrue($testUser->checkCapability('OWN_USER'));

        TestCase::assertFalse($testUser->checkCapability('GOAT'));
    }

    /**
     * Test checkCapability method
     *
     * @return void
     */
    public function testSubSetCapabilityCheck()
    {
        $testUser = $this->Users->get(1);

        $this->Users->patchCapabilities($testUser);
        $testUser = $this->Users->get(1);

        // All Capability
        TestCase::assertTrue($testUser->checkCapability('ALL', 1));
        TestCase::assertTrue($testUser->checkCapability('ALL', null, 1));
        $this->notAll($testUser);
        TestCase::assertFalse($testUser->checkCapability('ALL', 1));
        TestCase::assertFalse($testUser->checkCapability('ALL', null, 1));

        // Group Check
        TestCase::assertTrue($testUser->checkCapability('EDIT_SECT', 1));
        TestCase::assertFalse($testUser->checkCapability('EDIT_SECT', 2));

        // Section Check
        TestCase::assertTrue($testUser->checkCapability('EDIT_USER', null, 1));
        TestCase::assertFalse($testUser->checkCapability('EDIT_USER', null, 2));
    }
}

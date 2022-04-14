<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Entity;

use App\Model\Entity\Capability;
use App\Model\Entity\User;
use App\Test\TestCase\Controller\AppTestTrait;
use Authorization\AuthorizationServiceInterface;
use Authorization\IdentityDecorator;
use Cake\TestSuite\TestCase;
use InvalidArgumentException;

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
    public function setUp(): void
    {
        parent::setUp();

        $this->User = new User();
        $this->Auth = $this->createMock(AuthorizationServiceInterface::class);

        $this->Users = $this->getTableLocator()->get('Users');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
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

        new IdentityDecorator($this->Auth, ['bad']);
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
        TestCase::markTestSkipped('4x Breaking Change');
    }

    /**
     * Test getIdentifier method
     *
     * @return void
     */
    public function testGetIdentifier()
    {
        $users = $this->getTableLocator()->get('Users');
        $testUser = $users->get(1);

        TestCase::assertEquals(1, $testUser->getIdentifier());
    }

    /**
     * @param User $user The user to be altered.
     * @return User
     */
    private function notAll($user)
    {
        $roleTypes = $this->getTableLocator()->get('RoleTypes');
        $superUser = $roleTypes->get(5, ['contain' => ['Capabilities']]);

        $allPermission = $roleTypes->Capabilities
            ->find()
            ->where([Capability::FIELD_CAPABILITY_CODE => 'ALL'])
            ->all()
            ->toList();
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
        TestCase::assertTrue($testUser->checkCapability('EDIT_SECT', [1, 2]));
        TestCase::assertFalse($testUser->checkCapability('EDIT_SECT', [2]));

        // Section Check
        TestCase::assertTrue($testUser->checkCapability('EDIT_USER', null, 1));
        TestCase::assertFalse($testUser->checkCapability('EDIT_USER', null, 2));
        TestCase::assertTrue($testUser->checkCapability('EDIT_USER', null, [1, 2]));
        TestCase::assertFalse($testUser->checkCapability('EDIT_USER', null, [2]));
    }
}

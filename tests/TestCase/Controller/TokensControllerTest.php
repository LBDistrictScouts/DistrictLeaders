<?php
namespace App\Test\TestCase\Controller;

use App\Controller\TokensController;
use App\Model\Entity\Token;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\TokensController Test Case
 *
 * @uses \App\Controller\TokensController
 */
class TokensControllerTest extends TestCase
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
    private $controller = 'Tokens';

    /**
     * @var array $validEntityData Valid creation Data.
     */
    private $validEntityData = [
        'token' => 'Password Reset for Jacob',
        'email_send_id' => 1,
        'active' => true,
        'random_number' => 1789,
        'token_header' => [
            'redirect' => [
                'controller' => 'Applications',
                'action' => 'view',
                'prefix' => false,
                1
            ],
            'authenticate' => true,
        ]
    ];

    /**
     * Test index method
     *
     * @return void
     *
     * @throws
     */
    public function testValidate()
    {
        /** @var \App\Model\Table\TokensTable $tokens */
        $tokens = TableRegistry::getTableLocator()->get('Tokens');

        $token = $tokens->prepareToken(1);

        $this->get([
            'controller' => 'Tokens',
            'action' => 'validate',
            'prefix' => false,
            $token
        ]);

        $this->assertRedirect([
            'controller' => 'Applications',
            'action' => 'view',
            'prefix' => false,
            1,
            '?' => [
                'token_id' => 1,
                'token' => $token,
            ]
        ]);
    }

    /**
     * Test index method
     *
     * @return void
     *
     * @throws
     */
    public function testValidateAndAuthenticate()
    {
        /** @var \App\Model\Table\TokensTable $tokens */
        $tokens = TableRegistry::getTableLocator()->get($this->controller);

        $tokenRow = $tokens->get(1);
        $tokenRow->set(Token::FIELD_TOKEN_HEADER, [
            'authenticate' => true,
            'redirect' => [
                'controller' => 'Users',
                'action' => 'view',
                'prefix' => false,
                1,
            ]
        ]);
        TestCase::assertNotFalse($tokens->save($tokenRow));

        $token = $tokens->prepareToken(1);

        $this->get([
            'controller' => 'Tokens',
            'action' => 'validate',
            'prefix' => false,
            $token
        ]);

        $this->assertRedirect([
            'controller' => 'Users',
            'action' => 'view',
            'prefix' => false,
            1,
            '?' => [
                'token_id' => 1,
                'token' => $token,
            ]
        ]);
    }
}

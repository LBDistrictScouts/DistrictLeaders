<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Model\Entity\Token;
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
     * @var string $controller The Name of the controller being interrogated.
     */
    private $controller = 'Tokens';

    /**
     * Test index method
     *
     * @return void
     * @throws
     */
    public function testValidate()
    {
        /** @var \App\Model\Table\TokensTable $tokens */
        $tokens = $this->getTableLocator()->get('Tokens');

        $token = $tokens->prepareToken(1);

        $this->get([
            'controller' => 'Tokens',
            'action' => 'validate',
            'prefix' => false,
            $token,
        ]);

        $this->assertRedirect([
            'controller' => 'Applications',
            'action' => 'view',
            'prefix' => false,
            1,
            '?' => [
                'token_id' => 1,
                'token' => $token,
            ],
        ]);
    }

    /**
     * Test index method
     *
     * @return void
     * @throws
     */
    public function testValidateAndAuthenticate()
    {
        /** @var \App\Model\Table\TokensTable $tokens */
        $tokens = $this->getTableLocator()->get($this->controller);

        $tokenRow = $tokens->get(1);
        $tokenRow->set(Token::FIELD_TOKEN_HEADER, [
            'authenticate' => true,
            'redirect' => [
                'controller' => 'Users',
                'action' => 'view',
                'prefix' => false,
                1,
            ],
        ]);
        TestCase::assertNotFalse($tokens->save($tokenRow));

        $token = $tokens->prepareToken(1);

        $this->get([
            'controller' => 'Tokens',
            'action' => 'validate',
            'prefix' => false,
            $token,
        ]);

        $this->assertRedirect([
            'controller' => 'Users',
            'action' => 'view',
            'prefix' => false,
            1,
            '?' => [
                'token_id' => 1,
                'token' => $token,
            ],
        ]);
    }
}

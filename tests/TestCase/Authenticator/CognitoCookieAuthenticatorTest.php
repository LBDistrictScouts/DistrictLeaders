<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link http://cakephp.org CakePHP(tm) Project
 * @since 4.0.0
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Test\TestCase\Authenticator;

use App\Authenticator\CognitoCookieAuthenticator;
use App\Authenticator\CognitoResult;
use App\Test\Fixture\FixtureTestTrait;
use App\Test\TestCase\AuthenticationTestCase as TestCase;
use ArrayObject;
use Authentication\Authenticator\Result;
use Authentication\Identifier\IdentifierCollection;
use Cake\Http\Cookie\Cookie;
use Cake\Http\Response;
use Cake\Http\ServerRequestFactory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class CognitoCookieAuthenticatorTest
 *
 * @package App\Test\TestCase\Authenticator
 */
class CognitoCookieAuthenticatorTest extends TestCase
{
    use FixtureTestTrait;

    /**
     * @var string the Password Token
     */
    protected $token;

    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        $this->skipIf(!class_exists(Cookie::class));

        parent::setUp();

        $this->token = password_hash($this->username . $this->password, PASSWORD_DEFAULT);
    }

    /**
     * testAuthenticateInvalidTokenMissingUsername
     *
     * @return void
     */
    public function testAuthenticateInvalidTokenMissingUsername()
    {
        $identifiers = new IdentifierCollection([
            'Cognito',
        ]);

        $request = ServerRequestFactory::fromGlobals(
            ['REQUEST_URI' => '/users'],
            null,
            null,
            [
                'CookieAuth' => '["' . $this->token . '"]',
            ]
        );
        $response = new Response();

        $authenticator = new CognitoCookieAuthenticator($identifiers);
        $result = $authenticator->authenticate($request, $response);

        static::assertInstanceOf(CognitoResult::class, $result);
        static::assertEquals(CognitoResult::FAILURE_CREDENTIALS_INVALID, $result->getStatus());
    }

    /**
     * testAuthenticateSuccess
     *
     * @return void
     */
    public function testAuthenticateSuccess()
    {
        $identifiers = new IdentifierCollection([
            'Cognito',
        ]);

        $request = ServerRequestFactory::fromGlobals(
            ['REQUEST_URI' => '/users'],
            null,
            null,
            [
                'CookieAuth' => '["' . $this->username . '","' . $this->token . '"]',
            ]
        );
        $response = new Response();

        $authenticator = new CognitoCookieAuthenticator($identifiers);
        $result = $authenticator->authenticate($request, $response);

        static::assertInstanceOf(CognitoResult::class, $result);
        static::assertEquals(CognitoResult::SUCCESS, $result->getStatus());
    }

    /**
     * testAuthenticateSuccess
     *
     * @return void
     */
    public function testAuthenticateExpandedCookie()
    {
        $identifiers = new IdentifierCollection([
            'Cognito',
        ]);

        $request = ServerRequestFactory::fromGlobals(
            ['REQUEST_URI' => '/users'],
            null,
            null,
            [
                'CookieAuth' => [$this->username, $this->token],
            ]
        );
        $response = new Response();

        $authenticator = new CognitoCookieAuthenticator($identifiers);
        $result = $authenticator->authenticate($request, $response);

        static::assertInstanceOf(CognitoResult::class, $result);
        static::assertEquals(CognitoResult::SUCCESS, $result->getStatus());
    }

    /**
     * testAuthenticateUnknownUser
     *
     * @return void
     */
    public function testAuthenticateUnknownUser()
    {
        $identifiers = new IdentifierCollection([
            'Authentication.Password',
        ]);

        $request = ServerRequestFactory::fromGlobals(
            ['REQUEST_URI' => '/testpath'],
            null,
            null,
            [
                'CookieAuth' => '["robert","$2y$10$1bE1SgasKoz9WmEvUfuZLeYa6pQgxUIJ5LAoS/KGmC1hNuWkUG7ES"]',
            ]
        );
        $response = new Response();

        $authenticator = new CognitoCookieAuthenticator($identifiers);
        $result = $authenticator->authenticate($request, $response);

        static::assertInstanceOf(Result::class, $result);
        static::assertEquals(Result::FAILURE_IDENTITY_NOT_FOUND, $result->getStatus());
    }

    /**
     * testCredentialsNotPresent
     *
     * @return void
     */
    public function testCredentialsNotPresent()
    {
        $identifiers = new IdentifierCollection([
            'Authentication.Password',
        ]);

        $request = ServerRequestFactory::fromGlobals(
            ['REQUEST_URI' => '/testpath']
        );
        $response = new Response();

        $authenticator = new CognitoCookieAuthenticator($identifiers);
        $result = $authenticator->authenticate($request, $response);

        static::assertInstanceOf(Result::class, $result);
        static::assertEquals(Result::FAILURE_CREDENTIALS_MISSING, $result->getStatus());
    }

    /**
     * testAuthenticateInvalidToken
     *
     * @return void
     */
    public function testAuthenticateInvalidToken()
    {
        $identifiers = new IdentifierCollection([
            'Authentication.Password',
        ]);

        $request = ServerRequestFactory::fromGlobals(
            ['REQUEST_URI' => '/testpath'],
            null,
            null,
            [
                'CookieAuth' => '["mariano","$2y$10$1bE1SgasKoz9WmEvUfuZLeYa6pQgxUIJ5LAoS/asdasdsadasd"]',
            ]
        );
        $response = new Response();

        $authenticator = new CognitoCookieAuthenticator($identifiers);
        $result = $authenticator->authenticate($request, $response);

        static::assertInstanceOf(Result::class, $result);
        static::assertEquals(Result::FAILURE_CREDENTIALS_INVALID, $result->getStatus());
    }

    /**
     * testPersistIdentity
     *
     * @return void
     */
    public function testPersistIdentity()
    {
        $identifiers = new IdentifierCollection([
            'Authentication.Password',
        ]);

        $request = ServerRequestFactory::fromGlobals(
            ['REQUEST_URI' => '/testpath']
        );
        $request = $request->withParsedBody([
            'remember_me' => 1,
        ]);
        $response = new Response();

        $authenticator = new CognitoCookieAuthenticator($identifiers);

        $identity = new ArrayObject([
            'username' => $this->username,
            'password' => '$2a$10$u05j8FjsvLBNdfhBhc21LOuVMpzpabVXQ9OpC2wO3pSO0q6t7HHMO',
        ]);
        $result = $authenticator->persistIdentity($request, $response, $identity);

        static::assertIsArray($result);
        static::assertArrayHasKey('request', $result);
        static::assertArrayHasKey('response', $result);
        static::assertInstanceOf(RequestInterface::class, $result['request']);
        static::assertInstanceOf(ResponseInterface::class, $result['response']);
        static::assertStringContainsString(
            'CookieAuth=%5B%22mariano%22%2C%22%242y%2410%24',
            $result['response']->getHeaderLine('Set-Cookie')
        );

        // Testing that the field is not present
        $request = $request->withParsedBody([]);
        $result = $authenticator->persistIdentity($request, $response, $identity);
        static::assertStringNotContainsString(
            'CookieAuth',
            $result['response']->getHeaderLine('Set-Cookie')
        );

        // Testing a different field name
        $request = $request->withParsedBody([
            'other_field' => 1,
        ]);
        $authenticator = new CognitoCookieAuthenticator($identifiers, [
            'rememberMeField' => 'other_field',
        ]);
        $result = $authenticator->persistIdentity($request, $response, $identity);
        static::assertStringContainsString(
            'CookieAuth=%5B%22mariano%22%2C%22%242y%2410%24',
            $result['response']->getHeaderLine('Set-Cookie')
        );
    }

    /**
     * testPersistIdentityLoginUrlMismatch
     *
     * @return void
     */
    public function testPersistIdentityLoginUrlMismatch()
    {
        $identifiers = new IdentifierCollection([
            'Authentication.Password',
        ]);

        $request = ServerRequestFactory::fromGlobals(
            ['REQUEST_URI' => '/testpath']
        );
        $request = $request->withParsedBody([
            'remember_me' => 1,
        ]);
        $response = new Response();

        $authenticator = new CognitoCookieAuthenticator($identifiers, [
            'loginUrl' => '/users/login',
        ]);

        $identity = new ArrayObject([
            'username' => 'mariano',
            'password' => '$2a$10$u05j8FjsvLBNdfhBhc21LOuVMpzpabVXQ9OpC2wO3pSO0q6t7HHMO',
        ]);
        $result = $authenticator->persistIdentity($request, $response, $identity);

        static::assertIsArray($result);
        static::assertArrayHasKey('request', $result);
        static::assertArrayHasKey('response', $result);
        static::assertInstanceOf(RequestInterface::class, $result['request']);
        static::assertInstanceOf(ResponseInterface::class, $result['response']);
        static::assertStringNotContainsString(
            'CookieAuth=%5B%22mariano%22%2C%22%242y%2410%24',
            $result['response']->getHeaderLine('Set-Cookie')
        );
    }

    /**
     * testClearIdentity
     *
     * @return void
     */
    public function testClearIdentity()
    {
        $identifiers = new IdentifierCollection([
            'Authentication.Password',
        ]);

        $request = ServerRequestFactory::fromGlobals(
            ['REQUEST_URI' => '/testpath']
        );
        $response = new Response();

        $authenticator = new CognitoCookieAuthenticator($identifiers);

        $result = $authenticator->clearIdentity($request, $response);
        static::assertIsArray($result);
        static::assertArrayHasKey('request', $result);
        static::assertArrayHasKey('response', $result);
        static::assertInstanceOf(RequestInterface::class, $result['request']);
        static::assertInstanceOf(ResponseInterface::class, $result['response']);

        static::assertEquals('CookieAuth=; expires=Thu, 01-Jan-1970 00:00:01 GMT+0000; path=/', $result['response']->getHeaderLine('Set-Cookie'));
    }
}

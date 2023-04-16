<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link https://cakephp.org CakePHP(tm) Project
 * @since 1.0.0
 * @license https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Test\TestCase\Authenticator;

use App\Authenticator\CognitoResult;
use App\Authenticator\CognitoSessionAuthenticator;
use App\Test\Fixture\FixtureTestTrait;
use App\Test\TestCase\AuthenticationTestCase as TestCase;
use ArrayObject;
use Authentication\Identifier\IdentifierCollection;
use Cake\Http\Response;
use Cake\Http\ServerRequestFactory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class CognitoSessionAuthenticatorTest
 *
 * @package App\Test\TestCase\Authenticator
 */
class CognitoSessionAuthenticatorTest extends TestCase
{
    use FixtureTestTrait;

    /**
     * @var IdentifierCollection The collection of Identifiers Specified
     */
    protected $identifiers;

    /**
     * @var MockObject a Mocked Session for Recording Auth in
     */
    protected $sessionMock;

    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->identifiers = new IdentifierCollection([
           'Authentication.Password',
        ]);

        $class = 'Cake\Http\Session';
        if (!class_exists($class)) {
            $class = '\Cake\Network\Session';
        }
        $this->sessionMock = $this->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->onlyMethods(['read', 'write', 'delete', 'renew', 'check'])
            ->getMock();
    }

    /**
     * Test authentication
     *
     * @return void
     */
    public function testAuthenticate()
    {
        $request = ServerRequestFactory::fromGlobals(['REQUEST_URI' => '/']);
        $response = new Response();

        $this->sessionMock->expects(static::at(0))
            ->method('read')
            ->with('Auth')
            ->will(static::returnValue([
                'username' => 'mariano',
                'password' => 'password',
            ]));

        $request = $request->withAttribute('session', $this->sessionMock);

        $authenticator = new CognitoSessionAuthenticator($this->identifiers);
        $result = $authenticator->authenticate($request, $response);

        static::assertInstanceOf(CognitoResult::class, $result);
        static::assertEquals(CognitoResult::SUCCESS, $result->getStatus());

        $this->sessionMock->expects($this->at(0))
            ->method('read')
            ->with('Auth')
            ->will(static::returnValue(null));

        $request = $request->withAttribute('session', $this->sessionMock);

        $authenticator = new CognitoSessionAuthenticator($this->identifiers);
        $result = $authenticator->authenticate($request, $response);

        static::assertInstanceOf(CognitoResult::class, $result);
        static::assertEquals(CognitoResult::FAILURE_IDENTITY_NOT_FOUND, $result->getStatus());
    }

    /**
     * Test session data verification by database lookup
     *
     * @return void
     */
    public function testVerifyByDatabase()
    {
        $request = ServerRequestFactory::fromGlobals(['REQUEST_URI' => '/']);
        $response = new Response();

        $this->sessionMock->expects(static::at(0))
            ->method('read')
            ->with('Auth')
            ->will(static::returnValue([
                'username' => 'mariano',
                'password' => 'h45h',
            ]));

        $request = $request->withAttribute('session', $this->sessionMock);

        $authenticator = new CognitoSessionAuthenticator($this->identifiers, [
            'identify' => true,
        ]);
        $result = $authenticator->authenticate($request, $response);

        static::assertInstanceOf(CognitoResult::class, $result);
        static::assertEquals(CognitoResult::SUCCESS, $result->getStatus());

        $this->sessionMock->expects($this->at(0))
            ->method('read')
            ->with('Auth')
            ->will(static::returnValue([
                'username' => 'does-not',
                'password' => 'exist',
            ]));

        $request = $request->withAttribute('session', $this->sessionMock);

        $authenticator = new CognitoSessionAuthenticator($this->identifiers, [
            'identify' => true,
        ]);
        $result = $authenticator->authenticate($request, $response);

        static::assertInstanceOf(CognitoResult::class, $result);
        static::assertEquals(CognitoResult::FAILURE_IDENTITY_NOT_FOUND, $result->getStatus());
    }

    /**
     * testPersistIdentity
     *
     * @return void
     */
    public function testPersistIdentity()
    {
        $request = ServerRequestFactory::fromGlobals(['REQUEST_URI' => '/']);
        $request = $request->withAttribute('session', $this->sessionMock);
        $response = new Response();
        $authenticator = new CognitoSessionAuthenticator($this->identifiers);

        $data = new ArrayObject(['username' => 'florian']);

        $this->sessionMock
            ->expects(static::at(0))
            ->method('check')
            ->with('Auth')
            ->willReturn(false);

        $this->sessionMock
            ->expects(static::once())
            ->method('renew');

        $this->sessionMock
            ->expects(static::once())
            ->method('write')
            ->with('Auth', $data);

        $this->sessionMock
            ->expects(static::at(3))
            ->method('check')
            ->with('Auth')
            ->willReturn(true);

        $result = $authenticator->persistIdentity($request, $response, $data);
        static::assertIsArray($result);
        static::assertArrayHasKey('request', $result);
        static::assertArrayHasKey('response', $result);
        static::assertInstanceOf(RequestInterface::class, $result['request']);
        static::assertInstanceOf(ResponseInterface::class, $result['response']);

        // Persist again to make sure identity isn't replaced if it exists.
        $authenticator->persistIdentity($request, $response, new ArrayObject(['username' => 'jane']));
    }

    /**
     * testClearIdentity
     *
     * @return void
     */
    public function testClearIdentity()
    {
        $request = ServerRequestFactory::fromGlobals(['REQUEST_URI' => '/']);
        $request = $request->withAttribute('session', $this->sessionMock);
        $response = new Response();

        $authenticator = new CognitoSessionAuthenticator($this->identifiers);

        $this->sessionMock->expects(static::at(0))
            ->method('delete')
            ->with('Auth');

        $this->sessionMock
            ->expects(static::at(1))
            ->method('renew');

        $result = $authenticator->clearIdentity($request, $response);
        static::assertIsArray($result);
        static::assertArrayHasKey('request', $result);
        static::assertArrayHasKey('response', $result);
        static::assertInstanceOf(RequestInterface::class, $result['request']);
        static::assertInstanceOf(ResponseInterface::class, $result['response']);
    }
}

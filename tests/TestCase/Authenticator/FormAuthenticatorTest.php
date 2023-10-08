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

use App\Test\TestCase\AuthenticationTestCase as TestCase;
use Authentication\Authenticator\FormAuthenticator;
use Authentication\Authenticator\Result;
use Authentication\Authenticator\ResultInterface;
use Authentication\Identifier\IdentifierCollection;
use Cake\Http\Response;
use Cake\Http\ServerRequestFactory;
use RuntimeException;

/**
 * Class FormAuthenticatorTest
 *
 * @package App\Test\TestCase\Authenticator
 */
class FormAuthenticatorTest extends TestCase
{
    /**
     * testAuthenticate
     *
     * @return void
     */
    public function testAuthenticate()
    {
        $identifiers = new IdentifierCollection([
           'Authentication.Password',
        ]);

        $request = ServerRequestFactory::fromGlobals(
            ['REQUEST_URI' => '/testpath'],
            [],
            ['username' => 'mariano', 'password' => 'password']
        );
        $response = new Response();

        $form = new FormAuthenticator($identifiers);
        $result = $form->authenticate($request, $response);

        static::assertInstanceOf(Result::class, $result);
        static::assertEquals(Result::SUCCESS, $result->getStatus());
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
            ['REQUEST_URI' => '/users/does-not-match'],
            [],
            []
        );
        $response = new Response();

        $form = new FormAuthenticator($identifiers);

        $result = $form->authenticate($request, $response);

        static::assertInstanceOf(Result::class, $result);
        static::assertEquals(Result::FAILURE_CREDENTIALS_MISSING, $result->getStatus());
        static::assertEquals([0 => 'Login credentials not found'], $result->getErrors());
    }

    /**
     * testCredentialsEmpty
     *
     * @return void
     */
    public function testCredentialsEmpty()
    {
        $identifiers = new IdentifierCollection([
           'Authentication.Password',
        ]);

        $request = ServerRequestFactory::fromGlobals(
            ['REQUEST_URI' => '/users/does-not-match'],
            [],
            ['username' => '', 'password' => '']
        );
        $response = new Response();

        $form = new FormAuthenticator($identifiers);

        $result = $form->authenticate($request, $response);

        static::assertInstanceOf(Result::class, $result);
        static::assertEquals(Result::FAILURE_CREDENTIALS_MISSING, $result->getStatus());
        static::assertEquals([0 => 'Login credentials not found'], $result->getErrors());
    }

    /**
     * testSingleLoginUrlMismatch
     *
     * @return void
     */
    public function testSingleLoginUrlMismatch()
    {
        $identifiers = new IdentifierCollection([
           'Authentication.Password',
        ]);

        $request = ServerRequestFactory::fromGlobals(
            ['REQUEST_URI' => '/users/does-not-match'],
            [],
            ['username' => 'mariano', 'password' => 'password']
        );
        $response = new Response();

        $form = new FormAuthenticator($identifiers, [
            'loginUrl' => '/users/login',
        ]);

        $result = $form->authenticate($request, $response);

        static::assertInstanceOf(Result::class, $result);
        static::assertEquals(Result::FAILURE_OTHER, $result->getStatus());
        static::assertEquals([0 => 'Login URL `/users/does-not-match` did not match `/users/login`.'], $result->getErrors());
    }

    /**
     * testMultipleLoginUrlMismatch
     *
     * @return void
     */
    public function testMultipleLoginUrlMismatch()
    {
        $identifiers = new IdentifierCollection([
           'Authentication.Password',
        ]);

        $request = ServerRequestFactory::fromGlobals(
            ['REQUEST_URI' => '/users/does-not-match'],
            [],
            ['username' => 'mariano', 'password' => 'password']
        );
        $response = new Response();

        $form = new FormAuthenticator($identifiers, [
            'loginUrl' => [
                '/en/users/login',
                '/de/users/login',
            ],
        ]);

        $result = $form->authenticate($request, $response);

        static::assertInstanceOf(Result::class, $result);
        static::assertEquals(Result::FAILURE_OTHER, $result->getStatus());
        static::assertEquals([0 => 'Login URL `/users/does-not-match` did not match `/en/users/login` or `/de/users/login`.'], $result->getErrors());
    }

    /**
     * testLoginUrlMismatchWithBase
     *
     * @return void
     */
    public function testLoginUrlMismatchWithBase()
    {
//        $this->markTestSkipped('Mock Breakage.');

        $identifiers = new IdentifierCollection([
            'Authentication.Password',
        ]);

        $request = ServerRequestFactory::fromGlobals(
            ['REQUEST_URI' => '/users/login'],
            [],
            ['username' => 'mariano', 'password' => 'password']
        );
        $mockerUri = $this->getMockBuilder('Cake\Http\Uri');
        $uri = $mockerUri
            ->onlyMethods(['_getUrlFromRequest'])
            ->getMock();

        $uri->method('_getUrlFromRequest')->willReturn('/base');

        $request = $request->withUri($uri);
        $request = $request->withAttribute('base', '/base');
        $response = new Response();

        $form = new FormAuthenticator($identifiers, [
            'loginUrl' => '/users/login',
        ]);

        $result = $form->authenticate($request, $response);

        $this->assertInstanceOf(Result::class, $result);
        $this->assertEquals(ResultInterface::FAILURE_OTHER, $result->getStatus());
        $this->assertEquals([0 => 'Login URL `/base/users/login` did not match `/users/login`.'], $result->getErrors());
    }

    /**
     * testSingleLoginUrlSuccess
     *
     * @return void
     */
    public function testSingleLoginUrlSuccess()
    {
        $identifiers = new IdentifierCollection([
           'Authentication.Password',
        ]);

        $request = ServerRequestFactory::fromGlobals(
            ['REQUEST_URI' => '/Users/login'],
            [],
            ['username' => 'mariano', 'password' => 'password']
        );
        $response = new Response();

        $form = new FormAuthenticator($identifiers, [
            'loginUrl' => '/Users/login',
        ]);

        $result = $form->authenticate($request, $response);

        $this->assertInstanceOf(Result::class, $result);
        $this->assertEquals(ResultInterface::SUCCESS, $result->getStatus());
        $this->assertEquals([], $result->getErrors());
    }

    /**
     * testMultipleLoginUrlSuccess
     *
     * @return void
     */
    public function testMultipleLoginUrlSuccess()
    {
        $identifiers = new IdentifierCollection([
           'Authentication.Password',
        ]);

        $request = ServerRequestFactory::fromGlobals(
            ['REQUEST_URI' => '/de/users/login'],
            [],
            ['username' => 'mariano', 'password' => 'password']
        );
        $response = new Response();

        $form = new FormAuthenticator($identifiers, [
            'loginUrl' => [
                '/en/users/login',
                '/de/users/login',
            ],
        ]);

        $result = $form->authenticate($request, $response);

        $this->assertInstanceOf(Result::class, $result);
        $this->assertEquals(Result::SUCCESS, $result->getStatus());
        $this->assertEquals([], $result->getErrors());
    }

    /**
     * testRegexLoginUrlSuccess
     *
     * @return void
     */
    public function testRegexLoginUrlSuccess()
    {
        $identifiers = new IdentifierCollection([
           'Authentication.Password',
        ]);

        $request = ServerRequestFactory::fromGlobals(
            ['REQUEST_URI' => '/de/users/login'],
            [],
            ['username' => 'mariano', 'password' => 'password']
        );
        $response = new Response();

        $form = new FormAuthenticator($identifiers, [
            'loginUrl' => '%^/[a-z]{2}/users/login/?$%',
            'urlChecker' => [
                'useRegex' => true,
            ],
        ]);

        $result = $form->authenticate($request, $response);

        $this->assertInstanceOf(Result::class, $result);
        $this->assertEquals(Result::SUCCESS, $result->getStatus());
        $this->assertEquals([], $result->getErrors());
    }

    /**
     * testFullRegexLoginUrlFailure
     *
     * @return void
     */
    public function testFullRegexLoginUrlFailure()
    {
        $identifiers = new IdentifierCollection([
           'Authentication.Password',
        ]);

        $request = ServerRequestFactory::fromGlobals(
            [
                'REQUEST_URI' => '/de/users/login',
            ],
            [],
            ['username' => 'mariano', 'password' => 'password']
        );
        $response = new Response();

        $form = new FormAuthenticator($identifiers, [
            'loginUrl' => '%auth\.localhost/[a-z]{2}/users/login/?$%',
            'urlChecker' => [
                'useRegex' => true,
                'checkFullUrl' => true,
            ],
        ]);

        $result = $form->authenticate($request, $response);

        $this->assertInstanceOf(Result::class, $result);
        $this->assertEquals(Result::FAILURE_OTHER, $result->getStatus());
        $this->assertEquals([0 => 'Login URL `http://localhost/de/users/login` did not match `%auth\.localhost/[a-z]{2}/users/login/?$%`.'], $result->getErrors());
    }

    /**
     * testRegexLoginUrlSuccess
     *
     * @return void
     */
    public function testFullRegexLoginUrlSuccess()
    {
        $identifiers = new IdentifierCollection([
           'Authentication.Password',
        ]);

        $request = ServerRequestFactory::fromGlobals(
            [
                'REQUEST_URI' => '/de/users/login',
                'SERVER_NAME' => 'auth.localhost',
            ],
            [],
            ['username' => 'mariano', 'password' => 'password']
        );
        $response = new Response();

        $form = new FormAuthenticator($identifiers, [
            'loginUrl' => '%auth\.localhost/[a-z]{2}/users/login/?$%',
            'urlChecker' => [
                'useRegex' => true,
                'checkFullUrl' => true,
            ],
        ]);

        $result = $form->authenticate($request, $response);

        $this->assertInstanceOf(Result::class, $result);
        $this->assertEquals(Result::SUCCESS, $result->getStatus());
        $this->assertEquals([], $result->getErrors());
    }

    /**
     * testAuthenticateCustomFields
     *
     * @return void
     */
    public function testAuthenticateCustomFields()
    {
        $identifiers = $this->createMock(IdentifierCollection::class);

        $request = ServerRequestFactory::fromGlobals(
            ['REQUEST_URI' => '/users/login'],
            [],
            ['email' => 'mariano@cakephp.org', 'secret' => 'password']
        );
        $response = new Response();

        $form = new FormAuthenticator($identifiers, [
            'loginUrl' => '/users/login',
            'fields' => [
                'username' => 'email',
                'password' => 'secret',
            ],
        ]);

        $identifiers->expects($this->once())
            ->method('identify')
            ->with([
                'username' => 'mariano@cakephp.org',
                'password' => 'password',
            ])
            ->willReturn([
                'username' => 'mariano@cakephp.org',
                'password' => 'password',
            ]);

        $form->authenticate($request, $response);
    }

    /**
     * testAuthenticateValidData
     *
     * @return void
     */
    public function testAuthenticateValidData()
    {
        $identifiers = $this->createMock(IdentifierCollection::class);

        $request = ServerRequestFactory::fromGlobals(
            ['REQUEST_URI' => '/users/login'],
            [],
            ['id' => 1, 'username' => 'mariano', 'password' => 'password']
        );
        $response = new Response();

        $form = new FormAuthenticator($identifiers, [
            'loginUrl' => '/users/login',
        ]);

        $identifiers->expects($this->once())
            ->method('identify')
            ->with([
                'username' => 'mariano',
                'password' => 'password',
            ])
            ->willReturn([
                'username' => 'mariano',
                'password' => 'password',
            ]);

        $form->authenticate($request, $response);
    }

    /**
     * testAuthenticateValidData
     *
     * @return void
     */
    public function testAuthenticateMissingChecker()
    {
        $identifiers = $this->createMock(IdentifierCollection::class);

        $request = ServerRequestFactory::fromGlobals(
            ['REQUEST_URI' => '/users/login'],
            [],
            ['id' => 1, 'username' => 'mariano', 'password' => 'password']
        );
        $response = new Response();

        $form = new FormAuthenticator($identifiers, [
            'loginUrl' => '/users/login',
            'urlChecker' => 'Foo',
        ]);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('URL checker class `Foo` was not found.');

        $form->authenticate($request, $response);
    }

    /**
     * testAuthenticateValidData
     *
     * @return void
     */
    public function testAuthenticateInvalidChecker()
    {
        $identifiers = $this->createMock(IdentifierCollection::class);

        $request = ServerRequestFactory::fromGlobals(
            ['REQUEST_URI' => '/users/login'],
            [],
            ['id' => 1, 'username' => 'mariano', 'password' => 'password']
        );
        $response = new Response();

        $form = new FormAuthenticator($identifiers, [
            'loginUrl' => '/users/login',
            'urlChecker' => self::class,
        ]);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage(
            'The provided URL checker class `App\Test\TestCase\Authenticator\FormAuthenticatorTest` ' .
            'does not implement the `Authentication\UrlChecker\UrlCheckerInterface` interface.'
        );

        $form->authenticate($request, $response);
    }
}

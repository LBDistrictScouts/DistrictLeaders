<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         3.3.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Test\TestCase;

use App\Application;
use Authentication\Middleware\AuthenticationMiddleware;
use Authorization\Middleware\AuthorizationMiddleware;
use Authorization\Middleware\RequestAuthorizationMiddleware;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Http\Middleware\EncryptedCookieMiddleware;
use Cake\Http\Middleware\SecurityHeadersMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use Cake\TestSuite\IntegrationTestCase;
use Cake\TestSuite\TestCase;
use InvalidArgumentException;

/**
 * ApplicationTest class
 */
class ApplicationTest extends IntegrationTestCase
{
    /**
     * testBootstrap
     *
     * @return void
     */
    public function testBootstrap()
    {
        $app = new Application(dirname(dirname(__DIR__)) . '/config');
        $app->bootstrap();
        $plugins = $app->getPlugins();

        $expectedPlugins = [
            'Muffin/Webservice',
            'Tools',
            'Search',
            'Queue',
            'Ajax',
            'Authentication',
            'Authorization',
            'Bake',
            'IdeHelper',
            'Migrations',
            'DebugKit',
            'BootstrapUI',
            'Muffin/Trash',
            'Muffin/Footprint',
            'Flash',
            'WyriHaximus/TwigView',
            'Expose',
            'TestHelper',
        ];

        foreach ($expectedPlugins as $plugin) {
            TestCase::assertSame($plugin, $plugins->get($plugin)->getName());
        }

        TestCase::assertCount(count($expectedPlugins), $plugins);
    }

    /**
     * testBootstrapPluginWithoutHalt
     *
     * @return void
     */
    public function testBootstrapPluginWithoutHalt()
    {
        $this->expectException(InvalidArgumentException::class);

        $app = $this->getMockBuilder(Application::class)
            ->setConstructorArgs([dirname(dirname(__DIR__)) . '/config'])
            ->setMethods(['addPlugin'])
            ->getMock();

        $app->method('addPlugin')
            ->will($this->throwException(new InvalidArgumentException('test exception.')));

        $app->bootstrap();
    }

    /**
     * testMiddleware
     *
     * @return void
     */
    public function testMiddleware()
    {
        $app = new Application(dirname(dirname(__DIR__)) . '/config');
        $middleware = new MiddlewareQueue();

        $middleware = $app->middleware($middleware);

        $middleware->seek(0);

        $middlewareArray = [
            ErrorHandlerMiddleware::class,
            AssetMiddleware::class,
            RoutingMiddleware::class,
            EncryptedCookieMiddleware::class,
            AuthenticationMiddleware::class,
            AuthorizationMiddleware::class,
            RequestAuthorizationMiddleware::class,
            SecurityHeadersMiddleware::class,
            CsrfProtectionMiddleware::class,
        ];

        foreach ($middlewareArray as $middlewareItem) {
            TestCase::assertInstanceOf($middlewareItem, $middleware->current());
            $middleware->next();
        }
    }
}

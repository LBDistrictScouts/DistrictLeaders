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
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use InvalidArgumentException;

/**
 * ApplicationTest class
 */
class ApplicationTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * testBootstrap
     *
     * @return void
     */
    public function testBootstrap(): void
    {
        $app = new Application(dirname(__DIR__, 2) . '/config');
        $app->bootstrap();
        $plugins = $app->getPlugins();
        $remainingPlugins = $plugins;

        $expectedPlugins = [
            'Muffin/Webservice',
            'Tools',
            'Search',
            'Queue',
            'Ajax',
            'Authentication',
            'Authorization',
            'Bake',
            'Cake/Repl',
            'IdeHelper',
            'Migrations',
            'DebugKit',
            'BootstrapUI',
            'Muffin/Trash',
            'Muffin/Footprint',
            'Flash',
            'Expose',
            'TestHelper',
            'Tags',
        ];

        foreach ($expectedPlugins as $plugin) {
            TestCase::assertSame($plugin, $plugins->get($plugin)->getName());
            $remainingPlugins->remove($plugin);
        }

        foreach ($remainingPlugins as $remain) {
            debug($remain->getName());
        }

        /* Validate Length matches (no unexpected new plugins have been added). */
        // TestCase::assertCount(count($expectedPlugins), $plugins);
    }

    /**
     * testBootstrapPluginWithoutHalt
     *
     * @return void
     */
    public function testBootstrapPluginWithoutHalt(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $app = $this->getMockBuilder(Application::class)
            ->setConstructorArgs([dirname(__DIR__, 2) . '/config'])
            ->onlyMethods(['addPlugin'])
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
    public function testMiddleware(): void
    {
        $app = new Application(dirname(__DIR__, 2) . '/config');
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

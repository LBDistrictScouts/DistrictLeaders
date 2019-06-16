<?php
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
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Http\Middleware\EncryptedCookieMiddleware;
use Cake\Http\Middleware\SecurityHeadersMiddleware;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use Cake\TestSuite\IntegrationTestCase;
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
            'Authentication',
            'Authorization',
            'Bake',
            'Migrations',
            'DebugKit',
            'BootstrapUI',
            'Muffin/Trash',
            'DatabaseLog',
            'Xety/Cake3CookieAuth',
            'Muffin/Tokenize',
            'Muffin/Footprint',
        ];

        $this->assertCount(count($expectedPlugins), $plugins);

        foreach ($expectedPlugins as $plugin) {
            $this->assertSame($plugin, $plugins->get($plugin)->getName());
        }
    }

    /**
     * testBootstrapPluginWitoutHalt
     *
     * @return void
     */
    public function testBootstrapPluginWitoutHalt()
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

        $this->assertInstanceOf(ErrorHandlerMiddleware::class, $middleware->get(0));
        $this->assertInstanceOf(EncryptedCookieMiddleware::class, $middleware->get(1));
        $this->assertInstanceOf(AuthenticationMiddleware::class, $middleware->get(2));
        $this->assertInstanceOf(AuthorizationMiddleware::class, $middleware->get(3));
        $this->assertInstanceOf(AssetMiddleware::class, $middleware->get(4));
        $this->assertInstanceOf(RoutingMiddleware::class, $middleware->get(5));
        $this->assertInstanceOf(SecurityHeadersMiddleware::class, $middleware->get(6));
        $this->assertInstanceOf(CsrfProtectionMiddleware::class, $middleware->get(7));
    }
}

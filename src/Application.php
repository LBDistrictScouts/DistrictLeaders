<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.3.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App;

use Cake\Core\Configure;
use Cake\Core\Exception\MissingPluginException;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\BaseApplication;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Http\Middleware\EncryptedCookieMiddleware;
use Cake\Http\Middleware\SecurityHeadersMiddleware;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;

/**
 * Application setup class.
 *
 * This defines the bootstrapping logic and middleware layers you
 * want to use in your application.
 */
class Application extends BaseApplication
{
    /**
     * {@inheritDoc}
     */
    public function bootstrap()
    {
        $this->addPlugin('DatabaseLog', ['bootstrap' => true]);

        $this->addPlugin('Xety/Cake3CookieAuth');

        $this->addPlugin('Muffin/Trash');

        $this->addPlugin('BootstrapUI');

        // Call parent to load bootstrap from files.
        parent::bootstrap();

        if (PHP_SAPI === 'cli') {
            try {
                $this->addPlugin('Bake');
            } catch (MissingPluginException $e) {
                // Do not halt if the plugin is missing
            }

            $this->addPlugin('Migrations');
        }

        /*
         * Only try to load DebugKit in development mode
         * Debug Kit should not be installed on a production system
         */
        if (Configure::read('debug')) {
            $this->addPlugin(\DebugKit\Plugin::class);
        }
    }

    /**
     * Setup the middleware queue your application will use.
     *
     * @param \Cake\Http\MiddlewareQueue $middlewareQueue The middleware queue to setup.
     * @return \Cake\Http\MiddlewareQueue The updated middleware queue.
     */
    public function middleware($middlewareQueue)
    {
        // Catch any exceptions in the lower layers,
        // and make an error page/response
        $middlewareQueue->add(new ErrorHandlerMiddleware(null, Configure::read('Error')));

        // Handle plugin/theme assets like CakePHP normally does.
        $middlewareQueue->add(new AssetMiddleware([
            'cacheTime' => Configure::read('Asset.cacheTime')
        ]));

        // Add routing middleware.
        // Routes collection cache enabled by default, to disable route caching
        // pass null as cacheConfig, example: `new RoutingMiddleware($this)`
        // you might want to disable this cache in case your routing is extremely simple
        $middlewareQueue->add(new RoutingMiddleware($this, '_cake_routes_'));

        $securityHeaders = new SecurityHeadersMiddleware();
        $securityHeaders
            ->setCrossDomainPolicy()
            ->setReferrerPolicy()
            ->setXFrameOptions()
            ->setXssProtection()
            ->noOpen()
            ->noSniff();

        $middlewareQueue->add($securityHeaders);

//      $middlewareQueue->add(new CsrfProtectionMiddleware([
//          'secure' => true,
//          'cookieName' => 'leaderCSRF'
//      ]));

        $middlewareQueue->add(new EncryptedCookieMiddleware(
            // Names of cookies to protect
            ['CookieAuth'],
            Configure::read('Security.cookieKey')
        ));

        return $middlewareQueue;
    }
}

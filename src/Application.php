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
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.3.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App;

use Ajax\Middleware\AjaxMiddleware;
use App\Policy\RequestPolicy;
use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Middleware\AuthenticationMiddleware;
use Authorization\AuthorizationService;
use Authorization\AuthorizationServiceProviderInterface;
use Authorization\Exception\ForbiddenException;
use Authorization\Exception\MissingIdentityException;
use Authorization\Middleware\AuthorizationMiddleware;
use Authorization\Middleware\RequestAuthorizationMiddleware;
use Authorization\Policy\MapResolver;
use Authorization\Policy\OrmResolver;
use Authorization\Policy\ResolverCollection;
use Cake\Core\Configure;
use Cake\Core\Exception\MissingPluginException;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\BaseApplication;
use Cake\Http\MiddlewareQueue;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Http\Middleware\EncryptedCookieMiddleware;
use Cake\Http\Middleware\SecurityHeadersMiddleware;
use Cake\Http\ServerRequest;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Application setup class.
 *
 * This defines the bootstrapping logic and middleware layers you
 * want to use in your application.
 */
class Application extends BaseApplication implements AuthorizationServiceProviderInterface, AuthenticationServiceProviderInterface
{
    protected const LOGIN_URL = '/users/login';

    /**
     * {@inheritDoc}
     */
    public function bootstrap(): void
    {
        $this->addPlugin('Flash');

        $this->addPlugin('CakeDto', ['bootstrap' => true]);

        $this->addPlugin('Tools', ['bootstrap' => true]);

        $this->addPlugin('Search');

        $this->addPlugin('Queue', ['routes' => true, 'bootstrap' => true]);

        $this->addPlugin('Ajax', ['bootstrap' => true]);

        $this->addPlugin('Muffin/Footprint');

        $this->addPlugin('DatabaseLog', ['bootstrap' => true]);

        $this->addPlugin('Authorization');

        $this->addPlugin('Authentication');

        $this->addPlugin('Muffin/Trash');

        $this->addPlugin('BootstrapUI');

        // Call parent to load bootstrap from files.
        parent::bootstrap();

        if (PHP_SAPI === 'cli') {
            try {
                $this->addPlugin('Bake');
                $this->addPlugin('IdeHelper');
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
            $this->addPlugin('DebugKit', ['bootstrap' => true]);
        }
    }

    /**
     * Setup the middleware queue your application will use.
     *
     * @param \Cake\Http\MiddlewareQueue $middlewareQueue The middleware queue to setup.
     * @return \Cake\Http\MiddlewareQueue The updated middleware queue.
     */
    public function middleware($middlewareQueue): MiddlewareQueue
    {
        $securityHeaders = new SecurityHeadersMiddleware();
        $securityHeaders
            ->setCrossDomainPolicy()
            ->setReferrerPolicy()
            ->setXFrameOptions()
            ->setXssProtection()
            ->noOpen()
            ->noSniff();

        // Catch any exceptions in the lower layers,
        // and make an error page/response
        $middlewareQueue
            ->add(new ErrorHandlerMiddleware(null, Configure::read('Error')))

            // Handle plugin/theme assets like CakePHP normally does.
            ->add(new AssetMiddleware([
                'cacheTime' => Configure::read('Asset.cacheTime'),
            ]))

            // Add routing middleware.
            // Routes collection cache enabled by default, to disable route caching
            // pass null as cacheConfig, example: `new RoutingMiddleware($this)`
            // you might want to disable this cache in case your routing is extremely simple
            ->add(new RoutingMiddleware($this, '_cake_routes_'))

            ->add(new EncryptedCookieMiddleware(
                // Names of cookies to protect
                ['CookieAuth'],
                Configure::read('Security.cookieKey')
            ))

            // Add the authentication middleware to the middleware queue
            ->add(new AuthenticationMiddleware($this))

            // Add the Authorisation Middleware to the middleware queue
            ->add(new AuthorizationMiddleware($this, [
                'identityDecorator' => function ($auth, $user) {
                    /** @var \App\Model\Entity\User $user */
                    return $user->setAuthorization($auth);
                },
                'unauthorizedHandler' => [
                    'className' => 'Authorization.Redirect',
                    'url' => self::LOGIN_URL,
                    'queryParam' => 'redirectUrl',
                    'exceptions' => [
                        MissingIdentityException::class,
                        ForbiddenException::class,
                    ],
                ],
                'requireAuthorizationCheck' => true,
            ]))

            ->add(new RequestAuthorizationMiddleware())

            ->add($securityHeaders)

            ->add(new CsrfProtectionMiddleware([
                'secure' => !Configure::read('debug'),
                'httpOnly' => true,
            ]))

            ->add(AjaxMiddleware::class);

        return $middlewareQueue;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request The Request Submitted
     * @param \Psr\Http\Message\ResponseInterface $response The Response Received
     *
     * @return \Authorization\AuthorizationService
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getAuthorizationService(ServerRequestInterface $request, ResponseInterface $response): AuthorizationService
    {
        $ormResolver = new OrmResolver();
        $mapResolver = new MapResolver();

        $mapResolver->map(ServerRequest::class, RequestPolicy::class);

        // Check the map resolver, and fallback to the orm resolver if
        // a resource is not explicitly mapped.
        $resolver = new ResolverCollection([$ormResolver, $mapResolver]);

        return new AuthorizationService($resolver);
    }

    /**
     * Returns a service provider instance.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request Request
     * @param \Psr\Http\Message\ResponseInterface $response Response
     *
     * @return \Authentication\AuthenticationService
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getAuthenticationService(ServerRequestInterface $request, ResponseInterface $response): AuthenticationService
    {
        $service = new AuthenticationService();

        $fields = [
            'username' => 'username',
            'password' => 'password',
        ];

        $service->setConfig([
            'unauthenticatedRedirect' => self::LOGIN_URL,
            'queryParam' => 'redirect',
        ]);

        // Load identifiers
        $service->loadIdentifier('Authentication.Password', compact('fields'));

        // Load the authenticators, you want session first
        $service->loadAuthenticator('Authentication.Session');
        $service->loadAuthenticator('Authentication.Form', [
            compact('fields'),
            'loginUrl' => [ self::LOGIN_URL, 'login' ],
        ]);
        $service->loadAuthenticator('Authentication.Cookie', [
            'rememberMeField' => 'remember_me',
            compact('fields'),
        ]);

        return $service;
    }
}

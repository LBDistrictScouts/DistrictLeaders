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

use App\Authenticator\CognitoAuthenticationService;
use App\Middleware\CognitoAuthenticationMiddleware;
use App\Model\Entity\User;
use App\Policy\RequestPolicy;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Authorization\AuthorizationService;
use Authorization\AuthorizationServiceInterface;
use Authorization\AuthorizationServiceProviderInterface;
use Authorization\Middleware\AuthorizationMiddleware;
use Authorization\Middleware\RequestAuthorizationMiddleware;
use Authorization\Policy\MapResolver;
use Authorization\Policy\OrmResolver;
use Authorization\Policy\ResolverCollection;
use Cake\Core\Configure;
use Cake\Core\ContainerInterface;
use Cake\Datasource\FactoryLocator;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\BaseApplication;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Http\Middleware\EncryptedCookieMiddleware;
use Cake\Http\Middleware\HttpsEnforcerMiddleware;
use Cake\Http\Middleware\SecurityHeadersMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\Http\ServerRequest;
use Cake\ORM\Locator\TableLocator;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Application setup class.
 *
 * This defines the bootstrapping logic and middleware layers you
 * want to use in your application.
 */

class Application extends BaseApplication implements
    AuthorizationServiceProviderInterface,
    AuthenticationServiceProviderInterface
{
    protected const LOGIN_URL = '/users/login';

    /**
     * @inheritDoc
     */
    public function bootstrap(): void
    {
        $this->addPlugin('Expose');

        $this->addPlugin('Muffin/Webservice');

        $this->addPlugin('Tools');

        $this->addPlugin('Search');

        $this->addPlugin('Queue');

        $this->addPlugin('Ajax');

        $this->addPlugin('Muffin/Footprint');

        $this->addPlugin('Authorization');

        $this->addPlugin('Authentication');

        $this->addPlugin('Muffin/Trash');

        $this->addPlugin('BootstrapUI');

        $this->addPlugin('Tags');

        // Call parent class to load bootstrap from files.
        parent::bootstrap();

        if (PHP_SAPI === 'cli') {
            $this->bootstrapCli();
        } else {
            FactoryLocator::add(
                'Table',
                (new TableLocator())->allowFallbackClass(false)
            );
        }

        /*
         * Only try to load DebugKit in development mode
         * Debug Kit should not be installed on a production system
         */
        if (Configure::read('debug')) {
            $this->addPlugin('DebugKit');
            $this->addPlugin('TestHelper');
        }
    }

    /**
     * Bootstrapping for CLI application.
     *
     * That is when running commands.
     *
     * @return void
     */
    protected function bootstrapCli(): void
    {
        $this->addOptionalPlugin('Bake');
        $this->addOptionalPlugin('Cake/Repl');
        $this->addOptionalPlugin('IdeHelper');

        $this->addPlugin('Migrations');
    }

    /**
     * Set up the middleware queue your application will use.
     *
     * @param \Cake\Http\MiddlewareQueue $middlewareQueue The middleware queue to set up.
     * @return \Cake\Http\MiddlewareQueue The updated middleware queue.
     */
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        $securityHeaders = new SecurityHeadersMiddleware();
        $securityHeaders
            ->setCrossDomainPolicy()
            ->setReferrerPolicy()
            ->setXFrameOptions()
            ->setXssProtection()
            ->noOpen()
            ->noSniff();

        if (Configure::read('debug')) {
            $unAuthArray = [
                'className' => 'Authorization.Exception',
            ];
        } else {
            $unAuthArray = [
                'className' => 'Authorization.Redirect',
                'url' => '/',
                'queryParam' => 'redirectUrl',
                'exceptions' => Configure::read('UnauthorizedExceptions'),
            ];
        }

        // Catch any exceptions in the lower layers,
        // and make an error page/response
        $middlewareQueue
            ->add(new ErrorHandlerMiddleware(Configure::read('Error')))

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
            ->add(new CognitoAuthenticationMiddleware($this, [
                'logoutRedirect' => '/',
            ]))

            // Add the Authorisation Middleware to the middleware queue
            ->add(new AuthorizationMiddleware($this, [
                'identityDecorator' => function (AuthorizationService $auth, User $user) {
                    return $user->setAuthorization($auth);
                },
                'unauthorizedHandler' => $unAuthArray,
                'requireAuthorizationCheck' => true,
            ]))

            ->add(new RequestAuthorizationMiddleware())

            ->add($securityHeaders)

            ->add(new CsrfProtectionMiddleware([
                'secure' => !Configure::read('debug'),
                'httponly' => true,
            ]))

            ->add(new BodyParserMiddleware())

            ->add(new HttpsEnforcerMiddleware([
                'disableOnDebug' => true,
                'headers' => ['X-Https-Upgrade' => true],
                'redirect' => true,
                'statusCode' => 302,
            ]));

//            ->add(AjaxMiddleware::class);

        return $middlewareQueue;
    }

    /**
     * Register application container services.
     *
     * @param \Cake\Core\ContainerInterface $container The Container to update.
     * @return void
     * @link https://book.cakephp.org/4/en/development/dependency-injection.html#dependency-injection
     */
    public function services(ContainerInterface $container): void
    {
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request The Request Submitted
     * @return \Authorization\AuthorizationServiceInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getAuthorizationService(ServerRequestInterface $request): AuthorizationServiceInterface
    {
        $ormResolver = new OrmResolver();
        $mapResolver = new MapResolver();

        $mapResolver->map(ServerRequest::class, RequestPolicy::class);

        $resolver = new ResolverCollection([$mapResolver, $ormResolver]);

        return new AuthorizationService($resolver);
    }

    /**
     * Returns a service provider instance.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request Request
     * @return \Authentication\AuthenticationServiceInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
    {
        $service = new CognitoAuthenticationService();

        $fields = [
            'username' => 'username',
            'password' => 'password',
        ];

        $service->setConfig([
            'unauthenticatedRedirect' => self::LOGIN_URL,
            'queryParam' => 'redirect',
        ]);

        // Load identifiers
        $service->loadIdentifier('Cognito', compact('fields'));

        // Load the authenticators, you want session first
        $service->loadAuthenticator('CognitoSession', [
            compact('fields'),
            'loginUrl' => [ self::LOGIN_URL, 'login' ],
        ]);
        $service->loadAuthenticator('Cognito', [
            compact('fields'),
            'loginUrl' => [ self::LOGIN_URL, 'login' ],
        ]);
        $service->loadAuthenticator('CognitoCookie', [
            'rememberMeField' => 'remember_me',
            compact('fields'),
            'loginUrl' => [ self::LOGIN_URL, 'login' ],
        ]);

        return $service;
    }
}

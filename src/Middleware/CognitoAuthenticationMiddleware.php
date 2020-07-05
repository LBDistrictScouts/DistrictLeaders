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
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         1.0.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Middleware;

use App\Authenticator\NewPasswordRequiredException;
use Authentication\Authenticator\AuthenticationRequiredException;
use Authentication\Authenticator\StatelessInterface;
use Authentication\Authenticator\UnauthenticatedException;
use Authentication\Middleware\AuthenticationMiddleware;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\RedirectResponse;
use Laminas\Diactoros\Stream;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Authentication Middleware
 */
class CognitoAuthenticationMiddleware extends AuthenticationMiddleware implements MiddlewareInterface
{
    protected const PASSWORD_URL_KEY = 'passwordUrl';

    /**
     * @param \Exception $error Exception to be handled
     * @return mixed
     */
    protected function responseReturn($error)
    {
        $body = new Stream('php://memory', 'rw');
        $body->write($error->getBody());
        $response = new Response();
        $response = $response->withStatus((int)$e->getCode())
            ->withBody($body);
        foreach ($e->getHeaders() as $header => $value) {
            $response = $response->withHeader($header, $value);
        }

        return $response;
    }

    /**
     * Callable implementation for the middleware stack.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request The request.
     * @param \Psr\Http\Server\RequestHandlerInterface $handler The request handler.
     * @return \Psr\Http\Message\ResponseInterface A response.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $path = $request->getUri()->getPath();
        $passwordUrl = $this->getConfig(self::PASSWORD_URL_KEY);

        $service = $this->getAuthenticationService($request);

        if ($path == $passwordUrl) {
            return $handler->handle($request);
        }

        try {
            $result = $service->authenticate($request);
        } catch (AuthenticationRequiredException $e) {
            return $this->responseReturn($e);
        } catch (NewPasswordRequiredException $e) {
            debug($e);

            return new RedirectResponse($passwordUrl);
        }

        $request = $request->withAttribute($service->getIdentityAttribute(), $service->getIdentity());
        $request = $request->withAttribute('authentication', $service);
        $request = $request->withAttribute('authenticationResult', $result);

        try {
            $response = $handler->handle($request);
            $authenticator = $service->getAuthenticationProvider();

            if ($authenticator !== null && !$authenticator instanceof StatelessInterface) {
                $return = $service->persistIdentity($request, $response, $result->getData());
                $response = $return['response'];
            }
        } catch (UnauthenticatedException $e) {
            $url = $service->getUnauthenticatedRedirectUrl($request);
            if ($url) {
                return new RedirectResponse($url);
            }
            throw $e;
        }

        return $response;
    }
}

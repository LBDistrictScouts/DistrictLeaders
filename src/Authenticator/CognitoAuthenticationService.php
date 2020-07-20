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
namespace App\Authenticator;

use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\Authenticator\PersistenceInterface;
use Authentication\Authenticator\ResultInterface;
use Authentication\Authenticator\StatelessInterface;
use Authentication\IdentityInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RuntimeException;

/**
 * Authentication Service
 */
class CognitoAuthenticationService extends AuthenticationService implements AuthenticationServiceInterface
{
    /**
     * {@inheritDoc}
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request The request.
     * @return \Authentication\Authenticator\ResultInterface The result object. If none of the adapters was a success
     *  the last failed result is returned.
     * @throws \RuntimeException Throws a runtime exception when no authenticators are loaded.
     */
    public function authenticate(ServerRequestInterface $request): ResultInterface
    {
        $result = null;
        /** @var \Authentication\Authenticator\AuthenticatorInterface $authenticator */
        foreach ($this->authenticators() as $authenticator) {
            $result = $authenticator->authenticate($request);
            if ($result->isValid()) {
                $this->_successfulAuthenticator = $authenticator;

                return $this->_result = $result;
            }

            if ($result instanceof CognitoResult && $result->isChallenge()) {
                $this->_successfulAuthenticator = $authenticator;

                return $this->_result = $result;
            }

            if ($authenticator instanceof StatelessInterface) {
                $authenticator->unauthorizedChallenge($request);
            }
        }

        if ($result === null) {
            throw new RuntimeException(
                'No authenticators loaded. You need to load at least one authenticator.'
            );
        }

        $this->_successfulAuthenticator = null;

        return $this->_result = $result;
    }

    /**
     * Sets identity data and persists it in the authenticators that support it.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request The request.
     * @param \Psr\Http\Message\ResponseInterface $response The response.
     * @param \ArrayAccess|array $identity Identity data.
     * @return array
     * @psalm-return array{request: \Psr\Http\Message\ServerRequestInterface, response: \Psr\Http\Message\ResponseInterface}
     */
    public function persistIdentity(ServerRequestInterface $request, ResponseInterface $response, $identity): array
    {
        foreach ($this->authenticators() as $authenticator) {
            if ($authenticator instanceof PersistenceInterface) {
                $result = $authenticator->persistIdentity($request, $response, $identity);
                $request = $result['request'];
                $response = $result['response'];
            }
        }

        if (!($identity instanceof IdentityInterface)) {
            $identity = $this->buildIdentity($identity);
        }

        return [
            'request' => $request->withAttribute($this->getConfig('identityAttribute'), $identity),
            'response' => $response,
        ];
    }

    /**
     * Gets the result of the last authenticate() call.
     *
     * @return \App\Authenticator\CognitoResult|null Authentication result interface
     */
    public function getResult(): ?ResultInterface
    {
        return $this->_result;
    }

    /**
     * Gets an identity object
     *
     * @return null|\Authentication\IdentityInterface
     */
    public function getIdentity(): ?IdentityInterface
    {
        if ($this->_result === null || !$this->_result->isValid()) {
            return null;
        }

        $identity = $this->_result->getData();
        if (!($identity instanceof IdentityInterface)) {
            $identity = $this->buildIdentity($identity);
        }

        return $identity;
    }
}

<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Authenticator;

use ArrayAccess;
use ArrayObject;
use Authentication\Authenticator\PersistenceInterface;
use Authentication\Authenticator\ResultInterface;
use Authentication\Identifier\IdentifierInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Session Authenticator
 */
class CognitoSessionAuthenticator extends CognitoAuthenticator implements PersistenceInterface
{
    /**
     * Default config for this object.
     * - `fields` The fields to use to verify a user by.
     * - `sessionKey` Session key.
     * - `identify` Whether to identify user data stored in a session.
     *
     * @var array
     */
    // phpcs:ignore SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
    protected $_defaultConfig = [
        'fields' => [
            IdentifierInterface::CREDENTIAL_USERNAME => 'username',
        ],
        'sessionKey' => 'Auth',
        'identify' => false,
        'identityAttribute' => 'identity',
    ];

    /**
     * @inheritDoc
     */
    public function persistIdentity(ServerRequestInterface $request, ResponseInterface $response, $identity): array
    {
        $sessionKey = $this->getConfig('sessionKey', 'Auth');
        /** @var \Cake\Http\Session $session */
        $session = $request->getAttribute('session');

        if (!$session->check($sessionKey)) {
            $session->renew();
            $session->write($sessionKey, $identity);
        }

        return [
            'request' => $request,
            'response' => $response,
        ];
    }

    /**
     * @inheritDoc
     */
    public function clearIdentity(ServerRequestInterface $request, ResponseInterface $response): array
    {
        $sessionKey = $this->getConfig('sessionKey', 'Auth');
        /** @var \Cake\Http\Session $session */
        $session = $request->getAttribute('session');
        $session->delete($sessionKey);
        $session->renew();

        return [
            'request' => $request->withoutAttribute($this->getConfig('identityAttribute')),
            'response' => $response,
        ];
    }

    /**
     * Authenticate a user using session data.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request The request to authenticate with.
     * @return \Authentication\Authenticator\ResultInterface
     */
    public function authenticate(ServerRequestInterface $request): ResultInterface
    {
        $sessionKey = $this->getConfig('sessionKey', 'Auth');
        /** @var \Cake\Http\Session $session */
        $session = $request->getAttribute('session');
        $user = $session->read($sessionKey);

        if (empty($user)) {
            return new CognitoResult(null, ResultInterface::FAILURE_IDENTITY_NOT_FOUND);
        }

        if ($this->getConfig('identify') === true) {
            $credentials = [];
            foreach ($this->getConfig('fields') as $key => $field) {
                $credentials[$key] = $user[$field];
            }

            return parent::doAuthentication($credentials);
        }

        if (!($user instanceof ArrayAccess)) {
            $user = new ArrayObject($user);
        }

        return new CognitoResult($user, ResultInterface::SUCCESS);
    }
}

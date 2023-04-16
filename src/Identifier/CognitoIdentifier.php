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

namespace App\Identifier;

use App\Utility\AwsBuilder;
use Authentication\Identifier\AbstractIdentifier;
use Authentication\Identifier\Resolver\ResolverAwareTrait;
use Authentication\Identifier\Resolver\ResolverInterface;
use Authentication\PasswordHasher\PasswordHasherFactory;
use Authentication\PasswordHasher\PasswordHasherInterface;
use Authentication\PasswordHasher\PasswordHasherTrait;

/**
 * Password Identifier
 *
 * Identifies authentication credentials with password
 *
 * ```
 *  new PasswordIdentifier([
 *      'fields' => [
 *          'username' => ['username', 'email'],
 *          'password' => 'password'
 *      ]
 *  ]);
 * ```
 *
 * When configuring PasswordIdentifier you can pass in config to which fields,
 * model and additional conditions are used.
 */
class CognitoIdentifier extends AbstractIdentifier
{
    use PasswordHasherTrait;
    use ResolverAwareTrait;

    /**
     * Default configuration.
     * - `fields` The fields to use to identify a user by:
     *   - `username`: one or many username fields.
     *   - `password`: password field.
     * - `resolver` The resolver implementation to use.
     * - `passwordHasher` Password hasher class. Can be a string specifying class name
     *    or an array containing `className` key, any other keys will be passed as
     *    config to the class. Defaults to 'Default'.
     *
     * @var array
     */
    protected array $_defaultConfig = [
        'fields' => [
            self::CREDENTIAL_USERNAME => 'username',
            self::CREDENTIAL_PASSWORD => 'password',
        ],
        'resolver' => 'Authentication.Orm',
        'passwordHasher' => null,
    ];

    /**
     * @var \Aws\CognitoIdentityProvider\CognitoIdentityProviderClient
     */
    protected CognitoIdentityProviderClient $client;

    /**
     * @var string ID for the Cognito User Pool
     */
    protected string $userPoolId;

    /**
     * @var string ID for the Application
     */
    protected string $poolClientId;

    /**
     * Constructor.
     *
     * @param array $config Config array.
     */
    public function __construct(array $config = [])
    {
        $this->setConfig($config);

        $this->userPoolId = AwsBuilder::getCognitoUserPoolId();
        $this->poolClientId = AwsBuilder::getCognitoAppClientId();
        $this->client = AwsBuilder::buildCognitoClient();

//        $result = $this->client->describeUserPoolClient([
//            'ClientId' => $this->poolClientId, // REQUIRED
//            'UserPoolId' => $this->userPoolId, // REQUIRED
//        ]);
//        debug($result);
//
//        $result = $this->client->describeUserPool([
//            'UserPoolId' => $this->userPoolId, // REQUIRED
//        ]);
//        debug($result);
    }

    /**
     * Return password hasher object.
     *
     * @return \Authentication\PasswordHasher\PasswordHasherInterface Password hasher instance.
     */
    public function buildPasswordHasher(): PasswordHasherInterface
    {
        if ($this->_passwordHasher === null) {
            $passwordHasher = $this->getConfig('passwordHasher');
            if ($passwordHasher !== null) {
                $passwordHasher = PasswordHasherFactory::build($passwordHasher);
            } else {
                $passwordHasher = $this->getPasswordHasher();
            }
            $this->_passwordHasher = $passwordHasher;
        }

        return $this->_passwordHasher;
    }

    /**
     * @inheritDoc
     */
    public function identify(array $data)
    {
        if (!isset($data[self::CREDENTIAL_USERNAME])) {
            return null;
        }

        $identity = $this->findIdentity($data[self::CREDENTIAL_USERNAME]);
        if (array_key_exists(self::CREDENTIAL_PASSWORD, $data)) {
            $password = $data[self::CREDENTIAL_PASSWORD];

            // Normal Identity (Password in User)
            if (!$this->checkCognito($identity) && $this->checkPassword($identity, $password)) {
                return $identity;
            }

            if ($this->checkCognito($identity)) {
                $result = $this->client->adminInitiateAuth([
                    'AuthFlow' => 'ADMIN_USER_PASSWORD_AUTH', // REQUIRED
                    'AuthParameters' => [
//                        'REFRESH_TOKEN' => $data[self::CREDENTIAL_TOKEN],
                        'USERNAME' => $data[self::CREDENTIAL_USERNAME],
                        'PASSWORD' => $data[self::CREDENTIAL_PASSWORD],
                    ],
                    'ClientId' => $this->poolClientId, // REQUIRED
                    'UserPoolId' => $this->userPoolId, // REQUIRED
                ]);

//                debug($result);

                if ($result->offsetExists('ChallengeName')) {
                    $challenge = $result->get('ChallengeName');
                    $challengeSession = $result->get('Session');
                    $challengeParameters = $result->get('ChallengeParameters');

                    if ($challenge == 'NEW_PASSWORD_REQUIRED') {
                        return compact(['challenge', 'challengeSession', 'challengeParameters']);
                    }
                }

                if ($result->offsetExists('AuthenticationResult')) {
                    return $this->findIdentity($data[self::CREDENTIAL_USERNAME]);
                }
            }

            return null;
        }

        return $identity;
    }

    /**
     * Find a user record using the username and password provided.
     * Input passwords will be hashed even when a user doesn't exist. This
     * helps mitigate timing attacks that are attempting to find valid usernames.
     *
     * @param \App\Identifier\ArrayAccess|array|null $identity The identity or null.
     * @param string|null $password The password.
     * @return bool
     */
    protected function checkPassword(array|ArrayAccess|null $identity, ?string $password): bool
    {
        $passwordField = $this->getConfig('fields.' . self::CREDENTIAL_PASSWORD);

        if ($identity === null) {
            $identity = [
                $passwordField => '',
            ];
        }

        $hasher = $this->buildPasswordHasher();
        $hashedPassword = $identity[$passwordField];
        if (!$hasher->check((string)$password, $hashedPassword)) {
            return false;
        }

        $this->_needsPasswordRehash = $hasher->needsRehash($hashedPassword);

        return true;
    }

    /**
     * Check if a user is Cognito Enabled
     *
     * @param \App\Identifier\ArrayAccess|array|null $identity The identity or null.
     * @return bool
     */
    protected function checkCognito(array|ArrayAccess|null $identity): bool
    {
        if ($identity === null) {
            return false;
        }

        if (!property_exists($identity, 'cognito_enabled')) {
            return false;
        }

        return (bool)$identity['cognito_enabled'];
    }

    /**
     * Find a user record using the username/identifier provided.
     *
     * @param string $identifier The username/identifier.
     * @return \ArrayAccess|array|null
     */
    protected function findIdentity(string $identifier): ArrayAccess|array|null
    {
        $fields = $this->getConfig('fields.' . self::CREDENTIAL_USERNAME);
        $conditions = [];
        foreach ((array)$fields as $field) {
            $conditions[$field] = $identifier;
        }

        return $this->getResolver()->find($conditions, ResolverInterface::TYPE_OR);
    }
}

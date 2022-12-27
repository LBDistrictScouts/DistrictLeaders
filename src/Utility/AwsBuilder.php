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
 * @since         2.2.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Utility;

use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient;
use Aws\Sdk;
use Cake\Core\Configure;

/**
 * Library of Text Encoding Functions
 */
class AwsBuilder
{
    protected const CONFIG_KEY = 'Aws';

    protected const AWS_REGION_KEY = 'region';
    protected const AWS_API_VERSION_KEY = 'version';
    protected const AWS_SHARED_CLIENT_KEY = 'shared_config';

    protected const AWS_COGNITO_SET_KEY = 'cognito';
    protected const AWS_COGNITO_APP_CLIENT_ID_KEY = 'ClientId';
    protected const AWS_COGNITO_USER_POOL_ID = 'UserPoolId';

    /**
     * Constructor.
     *
     * @return array
     */
    public static function getConfigArray(): array
    {
        $sharedConfig = [
            self::AWS_REGION_KEY => Configure::read(self::CONFIG_KEY . '.' . self::AWS_REGION_KEY, 'eu-west-1'),
            self::AWS_API_VERSION_KEY => Configure::read(self::CONFIG_KEY . '.' . self::AWS_API_VERSION_KEY, 'latest'),
        ];

        return [
            self::AWS_SHARED_CLIENT_KEY => $sharedConfig,
            self::AWS_COGNITO_SET_KEY => Configure::read(self::CONFIG_KEY . '.' . self::AWS_COGNITO_SET_KEY, [
                self::AWS_COGNITO_APP_CLIENT_ID_KEY => '<<APP_CLIENT_ID>>',
                self::AWS_COGNITO_USER_POOL_ID => '<<USER_POOL_ID>>',
            ]),
        ];
    }

    /**
     * Constructor.
     *
     * @return string
     */
    public static function getCognitoAppClientId(): string
    {
        $config = self::getConfigArray();

        return $config[self::AWS_COGNITO_SET_KEY][self::AWS_COGNITO_APP_CLIENT_ID_KEY];
    }

    /**
     * Constructor.
     *
     * @return string
     */
    public static function getCognitoUserPoolId(): string
    {
        $config = self::getConfigArray();

        return $config[self::AWS_COGNITO_SET_KEY][self::AWS_COGNITO_USER_POOL_ID];
    }

    /**
     * Constructor.
     *
     * @return Sdk
     */
    public static function buildSdk(): Sdk
    {
        $config = self::getConfigArray();

        return new Sdk($config[self::AWS_SHARED_CLIENT_KEY]);
    }

    /**
     * Constructor.
     *
     * @return CognitoIdentityProviderClient
     */
    public static function buildCognitoClient(): CognitoIdentityProviderClient
    {
        return self::buildSdk()->createCognitoIdentityProvider();
    }
}

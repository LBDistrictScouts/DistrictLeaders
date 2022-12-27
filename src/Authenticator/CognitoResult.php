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

use ArrayAccess;
use Authentication\Authenticator\Result;
use Authentication\Authenticator\ResultInterface;
use InvalidArgumentException;

/**
 * Authentication result object
 */
class CognitoResult extends Result implements ResultInterface
{
    /**
     * Authentication result status
     *
     * @var string
     */
    protected $_challenge;

    /**
     * Failure due to identity not being found.
     */
    public const CHALLENGE_EXPIRED_PASSWORD = 'CHALLENGE_EXPIRED_PASSWORD';

    /**
     * Sets the result status, identity, and failure messages
     *
     * @param null|array|ArrayAccess $data The identity data
     * @param string $status Status constant equivalent.
     * @param array $messages Messages.
     * @throws InvalidArgumentException When invalid identity data is passed.
     */
    public function __construct($data, $status, array $messages = [])
    {
        if ($status === self::SUCCESS && empty($data)) {
            throw new InvalidArgumentException('Identity data can not be empty with status success.');
        }
        if ($data !== null && !is_array($data) && !($data instanceof ArrayAccess)) {
            $type = is_object($data) ? get_class($data) : gettype($data);
            $message = sprintf(
                'Identity data must be `null`, an `array` or implement `ArrayAccess` interface, `%s` given.',
                $type
            );
            throw new InvalidArgumentException($message);
        }

        $this->_challenge = false;
        switch ($status) {
            case self::SUCCESS:
                $this->_status = self::SUCCESS;
                break;
            case 'NEW_PASSWORD_REQUIRED':
                $this->_status = self::CHALLENGE_EXPIRED_PASSWORD;
                $this->_challenge = true;
                break;
            default:
                $this->_status = $status;
        }

        $this->_data = $data;
        $this->_errors = $messages;
    }

    /**
     * Returns whether the result represents a successful authentication attempt.
     *
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->_status === ResultInterface::SUCCESS;
    }

    /**
     * Returns whether the result represents a successful authentication attempt.
     *
     * @return bool
     */
    public function isChallenge(): bool
    {
        return $this->_challenge;
    }

    /**
     * Get the result status for this authentication attempt.
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->_status;
    }

    /**
     * Returns the identity data used in the authentication attempt.
     *
     * @return ArrayAccess|array|null
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * Returns an array of string reasons why the authentication attempt was unsuccessful.
     *
     * If authentication was successful, this method returns an empty array.
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->_errors;
    }
}

<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @since         3.7.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Policy;

use App\Model\Entity\User;
use Authorization\IdentityInterface;
use Authorization\Policy\Result;

/**
 * A trait intended to make application tests of your controllers easier.
 */
trait AppPolicyTrait
{
    /**
     * @param \Authorization\IdentityInterface|null $identity Identity object.
     * @param mixed $resource The resource being operated on.
     * @param string $action The action/operation being performed.
     * @return \Authorization\Policy\Result|null
     * @throws \Exception
     *
     * phpcs:ignore SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     */
    public function before(?IdentityInterface $identity, mixed $resource, string $action): ?Result
    {
        if (is_null($identity)) {
            return new Result(false, 'User not present. Auth error.');
        }

        if ($identity->checkCapability('ALL')) {
            return new Result(true, '900');
        }

        if ($identity->checkCapability($action)) {
            return new Result(true, 'Action specific capability present.');
        }

        return null;
    }

    /**
     * @param \App\Model\Entity\User $user The user to be processed
     * @param string $message The message to record
     * @return \Authorization\Policy\Result|null
     */
    protected function canBuildAndCheck(User $user, string $message): ?Result
    {
        if ($user->buildAndCheckCapability('VIEW', 'Notifications')) {
            return new Result(true, $message);
        }

        return null;
    }
}

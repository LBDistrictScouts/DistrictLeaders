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

use Authorization\Policy\Result;
use Cake\ORM\Entity;

/**
 * A trait intended to make application tests of your controllers easier.
 */
trait AppPolicyTrait
{
    /**
     * @param \App\Model\Entity\User $user Identity object.
     * @param mixed $resource The resource being operated on.
     * @param string $action The action/operation being performed.
     * @return \Authorization\Policy\Result|null
     */
    public function before($user, $resource, $action): ?Result
    {
        if (is_null($user)) {
            return new Result(false, 'User not present. Auth error.');
        }

        if ($user->checkCapability('ALL')) {
            return new Result(true, 'ALL capability present.');
        }

        if ($user->checkCapability($action)) {
            return new Result(true, 'Action specific capability present.');
        }

        if ($resource instanceof Entity) {
            /** @var \Cake\ORM\Entity $model */
            $model = $resource->getSource();

            if ($user->buildAndCheckCapability($action, $model)) {
                return new Result(true, 'Entity specific capability present.');
            }
        }

        return null;
    }
}

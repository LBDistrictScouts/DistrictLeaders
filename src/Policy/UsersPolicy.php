<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\User;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\Result;
use Authorization\Policy\ResultInterface;
use Cake\Log\Log;

/**
 * Class UserPolicy
 *
 * @package App\Policy
 */
class UsersPolicy implements BeforePolicyInterface
{
    use AppPolicyTrait;

    /**
     * @param User $user The User Editing
     * @param User $subject The User being Edited
     * @return ResultInterface
     */
    public function canUpdate(User $user, User $subject): ResultInterface
    {
        if ($user->id == $subject->id && $user->checkCapability('OWN_USER')) {
            return new Result(true);
        }

        if ($user->buildAndCheckCapability('UPDATE', 'Users')) {
            return new Result(true, 'Has Update Capability.');
        }

        // Results let you define a 'reason' for the failure.
        return new Result(false, 'not-owner');
    }

    /**
     * @param User $user The User Editing
     * @param User $subject The User being Edited
     * @return ResultInterface
     */
    public function canView(User $user, User $subject): ResultInterface
    {
        if ($user->id == $subject->id && $user->checkCapability('OWN_USER')) {
            return new Result(true);
        }

        if ($user->checkCapability('DIRECTORY')) {
            return new Result(true);
        }

        if ($user->buildAndCheckCapability('VIEW', 'Users')) {
            return new Result(true);
        }

        // Results let you define a 'reason' for the failure.
        return new Result(false, 'Not Own User and Cannot View Users.');
    }

    /**
     * @param User $user The User Editing
     * @return ResultInterface
     */
    public function canIndex(User $user): ResultInterface
    {
        Log::debug('can-index');
        if ($user->checkCapability('DIRECTORY')) {
            return new Result(true);
        }

        if ($user->buildAndCheckCapability('VIEW', 'Users')) {
            return new Result(true);
        }

        return new Result(false, 'Cannot View Users');
    }
}

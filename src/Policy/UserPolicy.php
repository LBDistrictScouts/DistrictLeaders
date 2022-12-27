<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\User;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\Result;

/**
 * Class UserPolicy
 *
 * @package App\Policy
 */
class UserPolicy implements BeforePolicyInterface
{
    use AppPolicyTrait;

    /**
     * @param User $user The User Editing
     * @param User $subject The User being Edited
     * @return Result
     */
    public function canEdit(User $user, User $subject)
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
     * @return Result
     */
    public function canView(User $user, User $subject)
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
     * @return Result
     */
    public function canIndex(User $user)
    {
        if ($user->checkCapability('DIRECTORY')) {
            return new Result(true);
        }

        if ($user->buildAndCheckCapability('VIEW', 'Users')) {
            return new Result(true);
        }

        return new Result(false, 'Cannot View Users');
    }
}

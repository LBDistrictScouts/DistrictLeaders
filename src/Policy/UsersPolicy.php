<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\User;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\Result;
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
     * @param \App\Model\Entity\User $user The User Editing
     * @param \App\Model\Entity\User $subject The User being Edited
     *
     * @return \Authorization\Policy\Result
     */
    public function canUpdate(User $user, User $subject)
    {
        if ($user->id == $subject->id && $user->checkCapability('OWN_USER')) {
            return new Result(true);
        }

        if ($user->buildAndCheckCapability('UPDATE', 'Users')) {
            return new Result(true);
        }

        // Results let you define a 'reason' for the failure.
        return new Result(false, 'not-owner');
    }

    /**
     * @param \App\Model\Entity\User $user The User Editing
     * @param \App\Model\Entity\User $subject The User being Edited
     *
     * @return \Authorization\Policy\Result
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
        return new Result(false, 'not-owner');
    }

    /**
     * @param \App\Model\Entity\User $user The User Editing
     *
     * @return \Authorization\Policy\Result
     */
    public function canIndex(User $user)
    {
        Log::debug('can-index');
        if ($user->checkCapability('DIRECTORY')) {
            return new Result(true);
        }

        if ($user->buildAndCheckCapability('VIEW', 'Users')) {
            return new Result(true);
        }
    }
}

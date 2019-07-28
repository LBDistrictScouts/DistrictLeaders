<?php
namespace App\Policy;

use App\Model\Entity\User;
use Authorization\Policy\Result;

/**
 * Class UserPolicy
 *
 * @package App\Policy
 */
class UserPolicy
{
    /**
     * @param \App\Model\Entity\User $user The User Editing
     * @param \App\Model\Entity\User $subject The User being Edited
     *
     * @return \Authorization\Policy\Result
     */
    public function canUpdate(User $user, User $subject)
    {
        if ($user->id == $subject->id) {
            return new Result(true);
        }
        // Results let you define a 'reason' for the failure.
        return new Result(false, 'not-owner');
    }
}

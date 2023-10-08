<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Notification;
use App\Model\Entity\User;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\Result;

/**
 * Class UserPolicy
 *
 * @package App\Policy
 */
class NotificationPolicy implements BeforePolicyInterface
{
    use AppPolicyTrait;

    /**
     * @param \App\Model\Entity\User $user The User Editing
     * @param \App\Model\Entity\Notification $subject The User being Edited
     * @return \Authorization\Policy\Result
     */
    public function canView(User $user, Notification $subject): Result
    {
        if ($user->id == $subject->user_id && $user->buildAndCheckCapability('VIEW', 'Notifications')) {
            return new Result(true, '106');
        }

        // Results let you define a 'reason' for the failure.
        return new Result(false, 'Not Own User Notification and Cannot View Users.');
    }

    /**
     * @param \App\Model\Entity\User $user The User Editing
     * @return \Authorization\Policy\Result
     */
    public function canIndex(User $user): Result
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

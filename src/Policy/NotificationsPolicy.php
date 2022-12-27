<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Notification;
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
class NotificationsPolicy implements BeforePolicyInterface
{
    use AppPolicyTrait;

    /**
     * @param User $user The User Editing
     * @param Notification $subject The Notification being Viewed
     * @return ResultInterface
     */
    public function canView(User $user, Notification $subject): ResultInterface
    {
        if ($user->id == $subject->user_id && $user->buildAndCheckCapability('VIEW', 'Notifications')) {
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

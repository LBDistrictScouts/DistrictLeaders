<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\User;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\Result;
use Cake\ORM\Query;

/**
 * Class UsersPolicy
 *
 * @package App\Policy
 */
class NotificationsTablePolicy implements BeforePolicyInterface
{
    use AppPolicyTrait;

    /**
     * @param User $user The User being authorized.
     * @param Query $query The Query object to be limited.
     * @return mixed
     */
    public function scopeIndex($user, $query)
    {
        if ($user->checkCapability('ALL')) {
            return $query;
        }

        return $query->where(['Notifications.user_id' => $user->getIdentifier()]);
    }

    /**
     * @param User $user The User being authorized.
     * @param Query $query The Query object to be limited.
     * @return mixed
     */
    public function scopeSearch($user, $query)
    {
        return $this->scopeIndex($user, $query);
    }

    /**
     * @param User $user The User being authorized.
     * @param Query $query The Query object to be limited.
     * @return mixed
     */
    public function scopeEdit($user, $query)
    {
        return $this->scopeIndex($user, $query);
    }

    /**
     * @param User $user The User Editing
     * @return Result|null
     */
    public function canIndex(User $user)
    {
        return $this->canBuildAndCheck($user, '106');
    }

    /**
     * @param User $user The User Editing
     * @return Result|null
     */
    public function canView(User $user)
    {
        return $this->canBuildAndCheck($user, '106');
    }
}

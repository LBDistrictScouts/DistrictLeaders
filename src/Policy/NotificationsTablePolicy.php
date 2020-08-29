<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\User;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\Result;

/**
 * Class UsersPolicy
 *
 * @package App\Policy
 */
class NotificationsTablePolicy implements BeforePolicyInterface
{
    use AppPolicyTrait;

    /**
     * @param \App\Model\Entity\User $user The User being authorized.
     * @param \Cake\ORM\Query $query The Query object to be limited.
     * @return mixed
     */
    public function scopeIndex($user, $query)
    {
        if ($user->buildAndCheckCapability('VIEW', 'Notifications')) {
            return $query;
        }

        return $query->where(['Notifications.user_id' => $user->getIdentifier()]);
    }

    /**
     * @param \App\Model\Entity\User $user The User being authorized.
     * @param \Cake\ORM\Query $query The Query object to be limited.
     * @return mixed
     */
    public function scopeSearch($user, $query)
    {
        return $this->scopeIndex($user, $query);
    }

    /**
     * @param \App\Model\Entity\User $user The User being authorized.
     * @param \Cake\ORM\Query $query The Query object to be limited.
     * @return mixed
     */
    public function scopeEdit($user, $query)
    {
        return $this->scopeIndex($user, $query);
    }

    /**
     * @param \App\Model\Entity\User $user The User Editing
     * @return \Authorization\Policy\Result
     */
    public function canIndex(User $user)
    {
        if ($user->buildAndCheckCapability('VIEW', 'Notifications')) {
            return new Result(true, '101');
        }

        return null;
    }

    /**
     * @param \App\Model\Entity\User $user The User Editing
     * @return \Authorization\Policy\Result
     */
    public function canView(User $user)
    {
        if ($user->buildAndCheckCapability('VIEW', 'Notifications')) {
            return new Result(true, '101');
        }

        return null;
    }

    /**
     * @param \App\Model\Entity\User $user The User Editing
     * @return \Authorization\Policy\Result|null
     */
    public function canAdd(User $user)
    {
        if ($user->buildAndCheckCapability('CREATE', 'Users')) {
            return new Result(true, '102');
        }

        return null;
    }
}

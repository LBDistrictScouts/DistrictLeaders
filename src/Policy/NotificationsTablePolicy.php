<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\User;
use Authorization\Policy\BeforePolicyInterface;
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
     * @param \App\Model\Entity\User $user The User being authorized.
     * @param \Cake\ORM\Query $query The Query object to be limited.
     * @return mixed
     */
    public function scopeIndex(User $user, Query $query): mixed
    {
        if ($user->checkCapability('ALL')) {
            return $query;
        }

        return $query->where(['Notifications.user_id' => $user->getIdentifier()]);
    }

    /**
     * @param \App\Model\Entity\User $user The User being authorized.
     * @param \Cake\ORM\Query $query The Query object to be limited.
     * @return mixed
     */
    public function scopeSearch(User $user, Query $query): mixed
    {
        return $this->scopeIndex($user, $query);
    }

    /**
     * @param \App\Model\Entity\User $user The User being authorized.
     * @param \Cake\ORM\Query $query The Query object to be limited.
     * @return mixed
     */
    public function scopeEdit(User $user, Query $query): mixed
    {
        return $this->scopeIndex($user, $query);
    }

    /**
     * @param \App\Model\Entity\User $user The User Editing
     * @return \Authorization\Policy\Result|null
     */
    public function canIndex(User $user): ?Result
    {
        return $this->canBuildAndCheck($user, '106');
    }

    /**
     * @param \App\Model\Entity\User $user The User Editing
     * @return \Authorization\Policy\Result|null
     */
    public function canView(User $user): ?Result
    {
        return $this->canBuildAndCheck($user, '106');
    }
}

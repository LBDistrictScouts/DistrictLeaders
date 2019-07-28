<?php
namespace App\Policy;

use App\Model\Entity\User;
use Authorization\Policy\BeforePolicyInterface;

/**
 * Class UsersPolicy
 *
 * @package App\Policy
 */
class UsersPolicy implements BeforePolicyInterface
{
    /**
     * @param \App\Model\Entity\User $user The User being authorized.
     * @param \Cake\ORM\Query $query The Query object to be limited.
     *
     * @return mixed
     */
    public function scopeIndex($user, $query)
    {
        return $query->where(['Users.id' => $user->getIdentifier()]);
    }

    /**
     * @param \App\Model\Entity\User|null $user The User being authorized
     * @param mixed $resource The resource checked
     * @param string $action the Action
     *
     * @return \Authorization\Policy\ResultInterface|bool|void
     */
    public function before($user, $resource, $action)
    {
        $userCapabilities = $user->getOriginalData()->capabilities['user'];
        if (in_array('ALL', $userCapabilities)) {
            return true;
        }
        // fall through
    }
}

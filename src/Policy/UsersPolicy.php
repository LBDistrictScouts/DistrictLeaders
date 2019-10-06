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
    use AppPolicyTrait;

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
}

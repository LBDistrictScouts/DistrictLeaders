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
class UsersTablePolicy implements BeforePolicyInterface
{
    use AppPolicyTrait;

    /**
     * @param \App\Model\Entity\User $user The User being authorized.
     * @param \Cake\ORM\Query $query The Query object to be limited.
     *
     * @return mixed
     */
    public function scopeList($user, $query)
    {
        if ($user->checkCapability('DIRECTORY')) {
            return $query;
        }

        return $query->where(['Users.id' => $user->getIdentifier()]);
    }

    /**
     * @param \App\Model\Entity\User $user The User being authorized.
     * @param \Cake\ORM\Query $query The Query object to be limited.
     *
     * @return mixed
     */
    public function scopeSearch($user, $query)
    {
        if ($user->checkCapability('DIRECTORY')) {
            return $query;
        }

        return $query->where(['Users.id' => $user->getIdentifier()]);
    }

    /**
     * @param \App\Model\Entity\User $user The User being authorized.
     * @param \Cake\ORM\Query $query The Query object to be limited.
     *
     * @return mixed
     */
    public function scopeUpdate($user, $query)
    {
        if ($user->checkCapability('EDIT_USER')) {
            return $query;
        }

        return $query->where(['Users.id' => $user->getIdentifier()]);
    }

    /**
     * @param \App\Model\Entity\User $user The User Editing
     *
     * @return \Authorization\Policy\Result
     */
    public function canIndex(User $user)
    {
        if ($user->checkCapability('DIRECTORY')) {
            return new Result(true);
        }

        if ($user->buildAndCheckCapability('VIEW', 'Users')) {
            return new Result(true);
        }
    }

    /**
     * @param \App\Model\Entity\User $user The User Editing
     *
     * @return \Authorization\Policy\Result
     */
    public function canView(User $user)
    {
        if ($user->checkCapability('DIRECTORY')) {
            return new Result(true);
        }

        if ($user->buildAndCheckCapability('VIEW', 'Users')) {
            return new Result(true);
        }
    }
}

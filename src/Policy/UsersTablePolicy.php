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
class UsersTablePolicy implements BeforePolicyInterface
{
    use AppPolicyTrait;

    /**
     * @param User $user The User being authorized.
     * @param Query $query The Query object to be limited.
     * @return mixed
     */
    public function scopeIndex($user, $query)
    {
        if ($user->checkCapability('DIRECTORY')) {
            return $query;
        }

        return $query->where(['Users.id' => $user->getIdentifier()]);
    }

    /**
     * @param User $user The User being authorized.
     * @param Query $query The Query object to be limited.
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
     * @param User $user The User being authorized.
     * @param Query $query The Query object to be limited.
     * @return mixed
     */
    public function scopeEdit($user, $query)
    {
        if ($user->checkCapability('EDIT_USER')) {
            return $query;
        }

        return $query->where(['Users.id' => $user->getIdentifier()]);
    }

    /**
     * @param User $user The User Editing
     * @return Result
     */
    public function canIndex(User $user)
    {
        if ($user->buildAndCheckCapability('VIEW', 'Users')) {
            return new Result(true, '101');
        }

        if ($user->checkCapability('DIRECTORY')) {
            return new Result(true, '100');
        }

        return null;
    }

    /**
     * @param User $user The User Editing
     * @return Result
     */
    public function canView(User $user)
    {
        if ($user->buildAndCheckCapability('VIEW', 'Users')) {
            return new Result(true, '101');
        }

        if ($user->checkCapability('DIRECTORY')) {
            return new Result(true, '100');
        }

        return null;
    }

    /**
     * @param User $user The User Editing
     * @return Result|null
     */
    public function canAdd(User $user)
    {
        if ($user->buildAndCheckCapability('CREATE', 'Users')) {
            return new Result(true, '102');
        }

        return null;
    }

    /**
     * @param User $user The User Editing
     * @return Result|null
     */
    public function canEdit(User $user)
    {
        if ($user->buildAndCheckCapability('UPDATE', 'Users')) {
            return new Result(true, '105');
        }

        if ($user->checkCapability('OWN_USER')) {
            return new Result(true, '103');
        }

        return null;
    }

    /**
     * @param User $user The User Logging In
     * @return Result
     */
    public function canLogin(User $user)
    {
        if ($user->checkCapability('LOGIN')) {
            return new Result(true, '50');
        }

        return null;
    }
}

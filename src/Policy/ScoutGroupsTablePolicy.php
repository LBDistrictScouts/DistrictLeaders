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
class ScoutGroupsTablePolicy implements BeforePolicyInterface
{
    use AppPolicyTrait;

    /**
     * @param User $user The User being authorized.
     * @param Query $query The Query object to be limited.
     * @return mixed
     */
    public function scopeIndex($user, $query)
    {
        if ($user->buildAndCheckCapability('VIEW', 'ScoutGroups')) {
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
        if ($user->buildAndCheckCapability('VIEW', 'ScoutGroups')) {
            return new Result(true, '200');
        }

        return null;
    }

    /**
     * @param User $user The User Editing
     * @return Result
     */
    public function canView(User $user)
    {
        if ($user->buildAndCheckCapability('VIEW', 'ScoutGroups')) {
            return new Result(true, '200');
        }

        return null;
    }

    /**
     * @param User $user The User Editing
     * @return Result|null
     */
    public function canAdd(User $user)
    {
        if ($user->buildAndCheckCapability('CREATE', 'ScoutGroups')) {
            return new Result(true, '201');
        }

        return null;
    }

    /**
     * @param User $user The User Editing
     * @return Result|null
     */
    public function canEdit(User $user)
    {
        if ($user->buildAndCheckCapability('UPDATE', 'ScoutGroups')) {
            return new Result(true, '202');
        }

        return null;
    }

    /**
     * @param User $user The User Editing
     * @return Result|null
     */
    public function canGenerate(User $user)
    {
        if ($user->buildAndCheckCapability('CREATE', 'ScoutGroups')) {
            return new Result(true, '201');
        }

        return null;
    }
}

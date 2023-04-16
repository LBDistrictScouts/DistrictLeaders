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
class ScoutGroupsTablePolicy implements BeforePolicyInterface
{
    use AppPolicyTrait;

    /**
     * @param \App\Model\Entity\User $user The User being authorized.
     * @param \Cake\ORM\Query $query The Query object to be limited.
     * @return mixed
     */
    public function scopeIndex(User $user, Query $query): mixed
    {
        if ($user->buildAndCheckCapability('VIEW', 'ScoutGroups')) {
            return $query;
        }

        return $query->where(['Users.id' => $user->getIdentifier()]);
    }

    /**
     * @param \App\Model\Entity\User $user The User Editing
     * @return \Authorization\Policy\Result
     */
    public function canIndex(User $user): Result
    {
        if ($user->buildAndCheckCapability('VIEW', 'ScoutGroups')) {
            return new Result(true, '200');
        }

        return null;
    }

    /**
     * @param \App\Model\Entity\User $user The User Editing
     * @return \Authorization\Policy\Result
     */
    public function canView(User $user): Result
    {
        if ($user->buildAndCheckCapability('VIEW', 'ScoutGroups')) {
            return new Result(true, '200');
        }

        return null;
    }

    /**
     * @param \App\Model\Entity\User $user The User Editing
     * @return \Authorization\Policy\Result|null
     */
    public function canAdd(User $user): ?Result
    {
        if ($user->buildAndCheckCapability('CREATE', 'ScoutGroups')) {
            return new Result(true, '201');
        }

        return null;
    }

    /**
     * @param \App\Model\Entity\User $user The User Editing
     * @return \Authorization\Policy\Result|null
     */
    public function canEdit(User $user): ?Result
    {
        if ($user->buildAndCheckCapability('UPDATE', 'ScoutGroups')) {
            return new Result(true, '202');
        }

        return null;
    }

    /**
     * @param \App\Model\Entity\User $user The User Editing
     * @return \Authorization\Policy\Result|null
     */
    public function canGenerate(User $user): ?Result
    {
        if ($user->buildAndCheckCapability('CREATE', 'ScoutGroups')) {
            return new Result(true, '201');
        }

        return null;
    }
}

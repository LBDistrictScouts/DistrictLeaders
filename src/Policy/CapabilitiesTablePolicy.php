<?php

declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\User;
use App\Model\Table\CapabilitiesTable;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\Result;
use Authorization\Policy\ResultInterface;

/**
 * CapabilitiesTable policy
 */
class CapabilitiesTablePolicy implements BeforePolicyInterface
{
    use AppPolicyTrait;

    /**
     * Check if $user can create CapabilitiesTable
     *
     * @param User $user The user.
     * @param CapabilitiesTable $capabilitiesTable Table to be Checked
     * @return Result|null
     */
    public function canIndex(User $user, CapabilitiesTable $capabilitiesTable): ResultInterface
    {
        if ($user->buildAndCheckCapability('VIEW', 'Capabilities')) {
            return new Result(true, '800');
        }

        return new Result(false, 'Capabilities requires admin level permissions.');
    }

    /**
     * Check if $user can create CapabilitiesTable
     *
     * @param User $user The user.
     * @param CapabilitiesTable $capabilitiesTable Table to be Checked
     * @return Result|null
     */
    public function canAdd(User $user, CapabilitiesTable $capabilitiesTable): ResultInterface
    {
        if ($user->buildAndCheckCapability('CREATE', 'Capabilities')) {
            return new Result(true, '802');
        }

        return new Result(false, 'Capabilities requires admin level permissions.');
    }

    /**
     * Check if $user can update CapabilitiesTable
     *
     * @param User $user The user.
     * @param CapabilitiesTable $capabilitiesTable Table to be Checked
     * @return Result|null
     */
    public function canEdit(User $user, CapabilitiesTable $capabilitiesTable): ResultInterface
    {
        if ($user->buildAndCheckCapability('DELETE', 'Capabilities')) {
            return new Result(true, '802');
        }

        return new Result(false, 'Capabilities requires admin level permissions.');
    }

    /**
     * Check if $user can delete CapabilitiesTable
     *
     * @param User $user The user.
     * @param CapabilitiesTable $capabilitiesTable Table to be Checked
     * @return Result|null
     */
    public function canDelete(User $user, CapabilitiesTable $capabilitiesTable): ResultInterface
    {
        if ($user->buildAndCheckCapability('DELETE', 'Capabilities')) {
            return new Result(true, '803');
        }

        return new Result(false, 'Capabilities requires admin level permissions.');
    }

    /**
     * Check if $user can view CapabilitiesTable
     *
     * @param User $user The user.
     * @param CapabilitiesTable $capabilitiesTable Table to be Checked
     * @return Result|null
     */
    public function canView(User $user, CapabilitiesTable $capabilitiesTable): ResultInterface
    {
        if ($user->buildAndCheckCapability('VIEW', 'Capabilities')) {
            return new Result(true, '800');
        }

        return new Result(false, 'Capabilities requires admin level permissions.');
    }

    /**
     * Check if $user can view CapabilitiesTable
     *
     * @param User $user The user.
     * @param CapabilitiesTable $capabilitiesTable Table to be Checked
     * @return Result|null
     */
    public function canViewPermissions(User $user, CapabilitiesTable $capabilitiesTable): ?ResultInterface
    {
        if ($user->buildAndCheckCapability('VIEW', 'Users')) {
            return new Result(true, '101');
        }

        if ($user->checkCapability('OWN_USER', 'Users')) {
            return new Result(true, '103');
        }

        return new Result(false, 'Capabilities Requires User Permissions.');
    }
}

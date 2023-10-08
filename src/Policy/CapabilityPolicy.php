<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Capability;
use App\Model\Entity\User;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\Result;
use Authorization\Policy\ResultInterface;

/**
 * Capability policy
 */
class CapabilityPolicy implements BeforePolicyInterface
{
    use AppPolicyTrait;

    /**
     * Check if $user can create a Capability
     *
     * @param \App\Model\Entity\User $user The user.
     * @param \App\Model\Entity\Capability $capability Entity to be Checked
     * @return \Authorization\Policy\ResultInterface|null
     */
    public function canAdd(User $user, Capability $capability): ResultInterface
    {
        if ($user->buildAndCheckCapability('CREATE', 'Capabilities')) {
            return new Result(true, '801');
        }

        return new Result(false, 'Capabilities requires admin level permissions.');
    }

    /**
     * Check if $user can update Capability
     *
     * @param \App\Model\Entity\User $user The user.
     * @param \App\Model\Entity\Capability $capability Entity to be Checked
     * @return \Authorization\Policy\ResultInterface|null
     */
    public function canEdit(User $user, Capability $capability): ResultInterface
    {
        if ($user->buildAndCheckCapability('UPDATE', 'Capabilities')) {
            return new Result(true, '801');
        }

        return new Result(false, 'Capabilities requires admin level permissions.');
    }

    /**
     * Check if $user can delete Capability
     *
     * @param \App\Model\Entity\User $user The user.
     * @param \App\Model\Entity\Capability $capability Entity to be Checked
     * @return \Authorization\Policy\ResultInterface|null
     */
    public function canDelete(User $user, Capability $capability): ?ResultInterface
    {
        if ($user->buildAndCheckCapability('DELETE', 'Capabilities')) {
            return new Result(true, '803');
        }

        return new Result(false, 'Capabilities requires admin level permissions.');
    }

    /**
     * Check if $user can view Capability
     *
     * @param \App\Model\Entity\User $user The user.
     * @param \App\Model\Entity\Capability $capability Entity to be Checked
     * @return \Authorization\Policy\ResultInterface|null
     */
    public function canView(User $user, Capability $capability): ?ResultInterface
    {
        if ($user->buildAndCheckCapability('VIEW', 'Capabilities')) {
            return new Result(true, '800');
        }

        return new Result(false, 'Capabilities requires admin level permissions.');
    }
}

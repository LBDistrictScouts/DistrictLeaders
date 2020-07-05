<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Table\AuditsTable;
use Authorization\Policy\BeforePolicyInterface;
use Authorization\Policy\Result;
use Authorization\Policy\ResultInterface;

/**
 * AuditsTable policy
 */
class AuditsTablePolicy implements BeforePolicyInterface
{
    use AppPolicyTrait;

    /**
     * Check if $user can index AuditsTable
     *
     * @param \App\Model\Entity\User $user The user.
     * @param \App\Model\Table\AuditsTable $auditsTable The Table to be Verified.
     * @return \Authorization\Policy\ResultInterface|null
     */
    public function canIndex($user, AuditsTable $auditsTable): ?ResultInterface
    {
        if ($user->checkCapability('HISTORY')) {
            return new Result(true, '104');
        }

        return new Result(false, 'User requires HISTORY permission to view changes.');
    }

    /**
     * Check if $user can view AuditsTable
     *
     * @param \App\Model\Entity\User $user The user.
     * @param \App\Model\Table\AuditsTable $auditsTable The Table to be Verified.
     * @return \Authorization\Policy\ResultInterface|null
     */
    public function canView($user, AuditsTable $auditsTable)
    {
        if ($user->checkCapability('HISTORY')) {
            return new Result(true, '104');
        }

        return new Result(false, 'User requires HISTORY permission to view changes.');
    }
}

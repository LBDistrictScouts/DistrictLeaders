<?php
namespace App\Policy;

use App\Model\Entity\User;
use Authorization\IdentityInterface;

class UserPolicy
{
    /**
     * @param \Authorization\IdentityInterface $user The User Editing
     * @param \App\Model\Entity\User $subject The User being Edited
     *
     * @return bool
     */
    public function canUpdate(IdentityInterface $user, User $subject)
    {
        return $user->id == $subject->user_id;
    }
}

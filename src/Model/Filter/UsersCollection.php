<?php
namespace App\Model\Filter;

use App\Model\Entity\RoleType;
use App\Model\Entity\SectionType;
use App\Model\Entity\User;
use App\Model\Entity\UserContact;
use Search\Model\Filter\FilterCollection;

class UsersCollection extends FilterCollection
{
    /**
     * Startup Method
     *
     * {@inheritDoc}
     */
    public function initialize()
    {
        $this
            ->add('q', 'Search.Like', [
                'before' => true,
                'after' => true,
                'fieldMode' => 'OR',
                'comparison' => 'ILIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'field' => [
                    User::FIELD_FIRST_NAME,
                    User::FIELD_LAST_NAME,
                    User::FIELD_EMAIL,
                    User::FIELD_USERNAME,
                    User::FIELD_POSTCODE,
                    User::FIELD_ADDRESS_LINE_1,
//                    'RoleTypes.' . RoleType::FIELD_ROLE_TYPE,
//                    'SectionTypes.' . SectionType::FIELD_SECTION_TYPE,
//                    'UserContacts.' . UserContact::FIELD_CONTACT_FIELD,
                ],
            ]);
    }
}

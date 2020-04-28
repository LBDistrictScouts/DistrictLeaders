<?php
declare(strict_types=1);

namespace App\Model\Filter;

use App\Model\Entity\User;
use Search\Model\Filter\FilterCollection;

class UsersCollection extends FilterCollection
{
    /**
     * {@inheritDoc}
     *
     * Startup Method
     *
     * @return void
     */
    public function initialize(): void
    {
        $this
            ->add('q', 'Search.Like', [
                'before' => true,
                'after' => true,
                'fieldMode' => 'OR',
                'comparison' => 'ILIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'fields' => [
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

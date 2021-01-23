<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * AuditFactory
 */
class AuditFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'Audits';
    }

    /**
     * Defines the factory's default values. This is useful for
     * not nullable fields. You may use methods of the present factory here too.
     *
     * @return void
     */
    protected function setDefaultTemplate(): void
    {
        $this->setDefaultData(function (Generator $faker) {
            return [
                // set the model's default values
                // For example:
                // 'name' => $faker->lastName
            ];
        });
    }

    /**
     * @param array|callable|null|int $parameter
     * @return AuditFactory
     */
    public function withChangedUsers($parameter = null): AuditFactory
    {
        return $this->with(
            'ChangedUsers',
            \App\Test\Factory\UserFactory::make($parameter)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @return AuditFactory
     */
    public function withChangedRoles($parameter = null): AuditFactory
    {
        return $this->with(
            'ChangedRoles',
            \App\Test\Factory\RoleFactory::make($parameter)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @return AuditFactory
     */
    public function withChangedUserContacts($parameter = null): AuditFactory
    {
        return $this->with(
            'ChangedUserContacts',
            \App\Test\Factory\UserContactFactory::make($parameter)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @return AuditFactory
     */
    public function withChangedScoutGroups($parameter = null): AuditFactory
    {
        return $this->with(
            'ChangedScoutGroups',
            \App\Test\Factory\ScoutGroupFactory::make($parameter)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @return AuditFactory
     */
    public function withChangedSections($parameter = null): AuditFactory
    {
        return $this->with(
            'ChangedSections',
            \App\Test\Factory\SectionFactory::make($parameter)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @return AuditFactory
     */
    public function withUsers($parameter = null): AuditFactory
    {
        return $this->with(
            'Users',
            \App\Test\Factory\UserFactory::make($parameter)
        );
    }
}

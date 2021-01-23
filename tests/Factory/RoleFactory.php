<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * RoleFactory
 */
class RoleFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'Roles';
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
     * @return RoleFactory
     */
    public function withRoleTypes($parameter = null): RoleFactory
    {
        return $this->with(
            'RoleTypes',
            \App\Test\Factory\RoleTypeFactory::make($parameter)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @return RoleFactory
     */
    public function withSections($parameter = null): RoleFactory
    {
        return $this->with(
            'Sections',
            \App\Test\Factory\SectionFactory::make($parameter)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @return RoleFactory
     */
    public function withUsers($parameter = null): RoleFactory
    {
        return $this->with(
            'Users',
            \App\Test\Factory\UserFactory::make($parameter)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @return RoleFactory
     */
    public function withRoleStatuses($parameter = null): RoleFactory
    {
        return $this->with(
            'RoleStatuses',
            \App\Test\Factory\RoleStatusFactory::make($parameter)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @return RoleFactory
     */
    public function withUserContacts($parameter = null): RoleFactory
    {
        return $this->with(
            'UserContacts',
            \App\Test\Factory\UserContactFactory::make($parameter)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @param int $n
     * @return RoleFactory
     */
    public function withAudits($parameter = null, int $n = 1): RoleFactory
    {
        return $this->with(
            'Audits',
            \App\Test\Factory\AuditFactory::make($parameter, $n)
        );
    }
}

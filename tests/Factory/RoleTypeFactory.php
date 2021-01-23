<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * RoleTypeFactory
 */
class RoleTypeFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'RoleTypes';
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
     * @return RoleTypeFactory
     */
    public function withSectionTypes($parameter = null): RoleTypeFactory
    {
        return $this->with(
            'SectionTypes',
            \App\Test\Factory\SectionTypeFactory::make($parameter)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @return RoleTypeFactory
     */
    public function withRoleTemplates($parameter = null): RoleTypeFactory
    {
        return $this->with(
            'RoleTemplates',
            \App\Test\Factory\RoleTemplateFactory::make($parameter)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @param int $n
     * @return RoleTypeFactory
     */
    public function withRoles($parameter = null, int $n = 1): RoleTypeFactory
    {
        return $this->with(
            'Roles',
            \App\Test\Factory\RoleFactory::make($parameter, $n)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @param int $n
     * @return RoleTypeFactory
     */
    public function withCapabilities($parameter = null, int $n = 1): RoleTypeFactory
    {
        return $this->with(
            'Capabilities',
            \App\Test\Factory\CapabilityFactory::make($parameter, $n)->without('RoleTypes')
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @param int $n
     * @return RoleTypeFactory
     */
    public function withDirectoryGroups($parameter = null, int $n = 1): RoleTypeFactory
    {
        return $this->with(
            'DirectoryGroups',
            \App\Test\Factory\DirectoryGroupFactory::make($parameter, $n)->without('RoleTypes')
        );
    }
}

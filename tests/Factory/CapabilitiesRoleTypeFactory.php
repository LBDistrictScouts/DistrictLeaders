<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * CapabilitiesRoleTypeFactory
 */
class CapabilitiesRoleTypeFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'CapabilitiesRoleTypes';
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
     * @return CapabilitiesRoleTypeFactory
     */
    public function withCapabilities($parameter = null): CapabilitiesRoleTypeFactory
    {
        return $this->with(
            'Capabilities',
            \App\Test\Factory\CapabilityFactory::make($parameter)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @return CapabilitiesRoleTypeFactory
     */
    public function withRoleTypes($parameter = null): CapabilitiesRoleTypeFactory
    {
        return $this->with(
            'RoleTypes',
            \App\Test\Factory\RoleTypeFactory::make($parameter)
        );
    }
}

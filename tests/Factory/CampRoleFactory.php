<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * CampRoleFactory
 */
class CampRoleFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'CampRoles';
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
     * @return CampRoleFactory
     */
    public function withCamps($parameter = null): CampRoleFactory
    {
        return $this->with(
            'Camps',
            \App\Test\Factory\CampFactory::make($parameter)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @return CampRoleFactory
     */
    public function withUsers($parameter = null): CampRoleFactory
    {
        return $this->with(
            'Users',
            \App\Test\Factory\UserFactory::make($parameter)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @return CampRoleFactory
     */
    public function withCampRoleTypes($parameter = null): CampRoleFactory
    {
        return $this->with(
            'CampRoleTypes',
            \App\Test\Factory\CampRoleTypeFactory::make($parameter)
        );
    }
}

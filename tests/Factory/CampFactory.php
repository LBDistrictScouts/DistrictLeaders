<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * CampFactory
 */
class CampFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'Camps';
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
     * @return CampFactory
     */
    public function withCampTypes($parameter = null): CampFactory
    {
        return $this->with(
            'CampTypes',
            \App\Test\Factory\CampTypeFactory::make($parameter)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @param int $n
     * @return CampFactory
     */
    public function withCampRoles($parameter = null, int $n = 1): CampFactory
    {
        return $this->with(
            'CampRoles',
            \App\Test\Factory\CampRoleFactory::make($parameter, $n)
        );
    }
}

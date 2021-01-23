<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * SectionTypeFactory
 */
class SectionTypeFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'SectionTypes';
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
     * @param int $n
     * @return SectionTypeFactory
     */
    public function withRoleTypes($parameter = null, int $n = 1): SectionTypeFactory
    {
        return $this->with(
            'RoleTypes',
            \App\Test\Factory\RoleTypeFactory::make($parameter, $n)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @param int $n
     * @return SectionTypeFactory
     */
    public function withSections($parameter = null, int $n = 1): SectionTypeFactory
    {
        return $this->with(
            'Sections',
            \App\Test\Factory\SectionFactory::make($parameter, $n)
        );
    }
}

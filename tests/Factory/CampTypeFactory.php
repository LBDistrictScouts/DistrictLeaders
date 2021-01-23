<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Factory;
use Faker\Generator;

/**
 * CampTypeFactory
 */
class CampTypeFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'CampTypes';
    }

    /**
     * Defines the factory's default values. This is useful for
     * not nullable fields. You may use methods of the present factory here too.
     *
     * @return void
     */
    protected function setDefaultTemplate(): void
    {
        $this->setDefaultData(function () {
            return self::getGood();
        });
    }

    public static function getGood(): array
    {
        $faker = Factory::create('en_GB');

        return [
            'camp_type' => ucwords($faker->words(3, true)),
        ];
    }
}

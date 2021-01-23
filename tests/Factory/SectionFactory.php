<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * SectionFactory
 */
class SectionFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'Sections';
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
     * @return SectionFactory
     */
    public function withSectionTypes($parameter = null): SectionFactory
    {
        return $this->with(
            'SectionTypes',
            \App\Test\Factory\SectionTypeFactory::make($parameter)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @return SectionFactory
     */
    public function withScoutGroups($parameter = null): SectionFactory
    {
        return $this->with(
            'ScoutGroups',
            \App\Test\Factory\ScoutGroupFactory::make($parameter)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @param int $n
     * @return SectionFactory
     */
    public function withAudits($parameter = null, int $n = 1): SectionFactory
    {
        return $this->with(
            'Audits',
            \App\Test\Factory\AuditFactory::make($parameter, $n)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @param int $n
     * @return SectionFactory
     */
    public function withRoles($parameter = null, int $n = 1): SectionFactory
    {
        return $this->with(
            'Roles',
            \App\Test\Factory\RoleFactory::make($parameter, $n)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @param int $n
     * @return SectionFactory
     */
    public function withUsers($parameter = null, int $n = 1): SectionFactory
    {
        return $this->with(
            'Users',
            \App\Test\Factory\UserFactory::make($parameter, $n)->without('Sections')
        );
    }
}

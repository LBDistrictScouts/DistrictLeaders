<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * ScoutGroupFactory
 */
class ScoutGroupFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'ScoutGroups';
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
     * @return ScoutGroupFactory
     */
    public function withSections($parameter = null, int $n = 1): ScoutGroupFactory
    {
        return $this->with(
            'Sections',
            \App\Test\Factory\SectionFactory::make($parameter, $n)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @param int $n
     * @return ScoutGroupFactory
     */
    public function withLeaderSections($parameter = null, int $n = 1): ScoutGroupFactory
    {
        return $this->with(
            'LeaderSections',
            \App\Test\Factory\SectionFactory::make($parameter, $n)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @param int $n
     * @return ScoutGroupFactory
     */
    public function withCommitteeSections($parameter = null, int $n = 1): ScoutGroupFactory
    {
        return $this->with(
            'CommitteeSections',
            \App\Test\Factory\SectionFactory::make($parameter, $n)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @param int $n
     * @return ScoutGroupFactory
     */
    public function withTeamSections($parameter = null, int $n = 1): ScoutGroupFactory
    {
        return $this->with(
            'TeamSections',
            \App\Test\Factory\SectionFactory::make($parameter, $n)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @param int $n
     * @return ScoutGroupFactory
     */
    public function withAudits($parameter = null, int $n = 1): ScoutGroupFactory
    {
        return $this->with(
            'Audits',
            \App\Test\Factory\AuditFactory::make($parameter, $n)
        );
    }
}

<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * DocumentEditionFactory
 */
class DocumentEditionFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'DocumentEditions';
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
     * @return DocumentEditionFactory
     */
    public function withDocumentVersions($parameter = null): DocumentEditionFactory
    {
        return $this->with(
            'DocumentVersions',
            \App\Test\Factory\DocumentVersionFactory::make($parameter)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @return DocumentEditionFactory
     */
    public function withFileTypes($parameter = null): DocumentEditionFactory
    {
        return $this->with(
            'FileTypes',
            \App\Test\Factory\FileTypeFactory::make($parameter)
        );
    }
}

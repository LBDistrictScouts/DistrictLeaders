<?php
declare(strict_types=1);

namespace App\Test\Factory;

use CakephpFixtureFactories\Factory\BaseFactory as CakephpBaseFactory;
use Faker\Generator;

/**
 * DocumentFactory
 */
class DocumentFactory extends CakephpBaseFactory
{
    /**
     * Defines the Table Registry used to generate entities with
     *
     * @return string
     */
    protected function getRootTableRegistryName(): string
    {
        return 'Documents';
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
     * @return DocumentFactory
     */
    public function withDocumentTypes($parameter = null): DocumentFactory
    {
        return $this->with(
            'DocumentTypes',
            \App\Test\Factory\DocumentTypeFactory::make($parameter)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @return DocumentFactory
     */
    public function withDocumentPreviews($parameter = null): DocumentFactory
    {
        return $this->with(
            'DocumentPreviews',
            \App\Test\Factory\DocumentEditionFactory::make($parameter)
        );
    }

    /**
     * @param array|callable|null|int $parameter
     * @param int $n
     * @return DocumentFactory
     */
    public function withDocumentVersions($parameter = null, int $n = 1): DocumentFactory
    {
        return $this->with(
            'DocumentVersions',
            \App\Test\Factory\DocumentVersionFactory::make($parameter, $n)
        );
    }
}

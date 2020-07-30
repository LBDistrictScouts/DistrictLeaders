<?php
declare(strict_types=1);

namespace App\Model\Filter;

use App\Model\Entity\Section;
use Search\Model\Filter\FilterCollection;

class SectionsCollection extends FilterCollection
{
    /**
     * {@inheritDoc}
     *
     * Startup Method
     *
     * @return void
     */
    public function initialize(): void
    {
        $this
            ->add('q', 'Search.Like', [
                'before' => true,
                'after' => true,
                'fieldMode' => 'OR',
                'comparison' => 'ILIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'fields' => [
                    Section::FIELD_SECTION,
                ],
            ]);
    }
}

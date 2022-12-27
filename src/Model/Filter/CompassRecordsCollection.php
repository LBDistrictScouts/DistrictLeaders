<?php

declare(strict_types=1);

namespace App\Model\Filter;

use App\Model\Entity\CompassRecord;
use Search\Model\Filter\FilterCollection;

/**
 * Class UsersCollection
 *
 * @package App\Model\Filter
 */
class CompassRecordsCollection extends FilterCollection
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
                    CompassRecord::FIELD_FORENAMES,
                    CompassRecord::FIELD_SURNAME,
                    CompassRecord::FIELD_EMAIL,
                ],
            ]);
    }
}

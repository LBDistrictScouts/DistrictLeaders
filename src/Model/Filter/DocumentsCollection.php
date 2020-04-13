<?php
declare(strict_types=1);

namespace App\Model\Filter;

use App\Model\Entity\Document;
use App\Model\Entity\DocumentType;
use Search\Model\Filter\FilterCollection;

class DocumentsCollection extends FilterCollection
{
    /**
     * Startup Method
     *
     * {@inheritDoc}
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
                    Document::FIELD_DOCUMENT,
                    'DocumentTypes.' . DocumentType::FIELD_DOCUMENT_TYPE,
                ],
            ]);
        // More $this->add() calls here. The argument for FilterCollection::add()
        // are same as those of searchManager()->add() shown above.
    }
}

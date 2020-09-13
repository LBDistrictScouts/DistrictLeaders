<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\Association;
use Cake\Utility\Inflector;

/**
 * Filter component
 */
class FilterComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * @param \Cake\ORM\Association $association The Association for Filtering on
     * @param array $queryParams The Query Params of the Request
     * @return \Cake\ORM\Query
     */
    public function indexFilters(Association $association, array $queryParams)
    {
        $baseTable = $association->getSource();
        $associatedTable = $association->getTarget();
        $listKey = $associatedTable->getDisplayField();
        $association->getTarget();

        $filterArray = $associatedTable->find('list')->toArray();
        $urlFilters = [];
        foreach ($queryParams as $param => $value) {
            $param = Inflector::humanize(urldecode($param));
            if (in_array($param, $filterArray)) {
                $urlFilters[$param] = $value;
            }
        }
        $appliedFilters = [];
        $appliedFilterIds = [];

        foreach ($urlFilters as $filter => $active) {
            if ($active) {
                $docType = $associatedTable->find()->where([$listKey => $filter])->firstOrFail();
                array_push($appliedFilterIds, $docType->get('id'));
                array_push($appliedFilters, $filter);
            }
        }

        $query = $baseTable->find()->contain($association->getName());

        if (!empty($appliedFilterIds)) {
            $query = $query->where([$association->getForeignKey() . ' IN' => $appliedFilterIds]);
        }

        $this->_registry->getController()->set(compact('filterArray', 'appliedFilters'));

        return $query;
    }
}

<?php
declare(strict_types=1);

/**
 * @var \App\View\AppView $this
 * @var string $tableClass
 * @var array|null $queryParams
 * @var int $objectId
 * @var string $action
 * @var mixed $entity
 */

$linkArray = [
    'controller' => $entity,
    'action' => $action,
];

if (isset($objectId) && !is_null($objectId)) {
    $linkArray[0] = $objectId;
}

if (isset($queryParams) && !is_null($queryParams)) {
    $linkArray['?'] = $queryParams;
}

if (!isset($actionName) || is_null($actionName)) {
    $actionName = $this->Inflection->singleSpace($action) . ' ' . $this->Inflection->singleSpace($entity);
}
?>
<?= $this->Html->link($actionName, $linkArray, ['class' => 'dropdown-item']);

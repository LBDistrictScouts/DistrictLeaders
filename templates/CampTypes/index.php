<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CampType[]|\Cake\Collection\CollectionInterface $campTypes
 */

$this->extend('../layout/CRUD/index');

$this->assign('entity', 'CampTypes');
$this->assign('subset', 'All');
$this->assign('add', $this->Identity->checkCapability('CREATE_CAMP_TYPE'));

?>
<thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('camp_type') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($campTypes as $campType): ?>
    <tr>
        <td><?= h($campType->camp_type) ?></td>
                <td class="actions">
            <?= $this->Identity->checkCapability('VIEW_CAMP_TYPE') ? $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $campType->id], ['title' => __('View Camp Type'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('UPDATE_CAMP_TYPE') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $campType->id], ['title' => __('Edit Camp Type'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('DELETE_CAMP_TYPE') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $campType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $campType->id), 'title' => __('Delete Camp Type'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>

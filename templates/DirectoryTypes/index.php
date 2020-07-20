<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DirectoryType[]|\Cake\Collection\CollectionInterface $directoryTypes
 */

$this->extend('../layout/CRUD/index');

$this->assign('entity', 'DirectoryTypes');
$this->assign('subset', 'All');
$this->assign('add', $this->Identity->checkCapability('CREATE_DIRECTORY_TYPE'));

?>
<thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
        <th scope="col"><?= $this->Paginator->sort('directory_type') ?></th>
        <th scope="col"><?= $this->Paginator->sort('directory_type_code') ?></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($directoryTypes as $directoryType): ?>
    <tr>
        <td><?= h($directoryType->id) ?></td>
                <td class="actions">
            <?= $this->Identity->checkCapability('VIEW_DIRECTORY_TYPE') ? $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $directoryType->id], ['title' => __('View Directory Type'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('UPDATE_DIRECTORY_TYPE') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $directoryType->id], ['title' => __('Edit Directory Type'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('DELETE_DIRECTORY_TYPE') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $directoryType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $directoryType->id), 'title' => __('Delete Directory Type'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
        </td>
        <td><?= h($directoryType->directory_type) ?></td>
        <td><?= h($directoryType->directory_type_code) ?></td>
    </tr>
    <?php endforeach; ?>
</tbody>
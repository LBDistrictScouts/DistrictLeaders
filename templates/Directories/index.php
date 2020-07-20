<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Directory[]|\Cake\Collection\CollectionInterface $directories
 */

$this->extend('../layout/CRUD/index');

$this->assign('entity', 'Directories');
$this->assign('subset', 'All');
$this->assign('add', $this->Identity->checkCapability('CREATE_DIRECTORY'));

?>
<thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
        <th scope="col"><?= $this->Paginator->sort('directory') ?></th>
        <th scope="col"><?= $this->Paginator->sort('configuration_payload') ?></th>
        <th scope="col"><?= $this->Paginator->sort('directory_type_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('active') ?></th>
        <th scope="col"><?= $this->Paginator->sort('customer_reference') ?></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($directories as $directory): ?>
    <tr>
        <td><?= h($directory->id) ?></td>
                <td class="actions">
            <?= $this->Identity->checkCapability('VIEW_DIRECTORY') ? $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $directory->id], ['title' => __('View Directory'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('UPDATE_DIRECTORY') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $directory->id], ['title' => __('Edit Directory'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('DELETE_DIRECTORY') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $directory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $directory->id), 'title' => __('Delete Directory'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
        </td>
        <td><?= h($directory->directory) ?></td>
        <td><?= h($directory->configuration_payload) ?></td>
        <td><?= $this->Number->format($directory->directory_type_id) ?></td>
        <td><?= h($directory->active) ?></td>
        <td><?= h($directory->customer_reference) ?></td>
    </tr>
    <?php endforeach; ?>
</tbody>
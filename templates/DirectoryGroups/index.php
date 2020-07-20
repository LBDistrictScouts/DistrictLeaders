<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DirectoryGroup[]|\Cake\Collection\CollectionInterface $directoryGroups
 */

$this->extend('../layout/CRUD/index');

$this->assign('entity', 'DirectoryGroups');
$this->assign('subset', 'All');
$this->assign('add', $this->Identity->checkCapability('CREATE_DIRECTORY_GROUP'));

?>
<thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
        <th scope="col"><?= $this->Paginator->sort('directory_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('directory_group_name') ?></th>
        <th scope="col"><?= $this->Paginator->sort('directory_group_email') ?></th>
        <th scope="col"><?= $this->Paginator->sort('directory_group_reference') ?></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($directoryGroups as $directoryGroup): ?>
    <tr>
        <td><?= h($directoryGroup->id) ?></td>
                <td class="actions">
            <?= $this->Identity->checkCapability('VIEW_DIRECTORY_GROUP') ? $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $directoryGroup->id], ['title' => __('View Directory Group'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('UPDATE_DIRECTORY_GROUP') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $directoryGroup->id], ['title' => __('Edit Directory Group'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('DELETE_DIRECTORY_GROUP') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $directoryGroup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $directoryGroup->id), 'title' => __('Delete Directory Group'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
        </td>
        <td><?= $this->Number->format($directoryGroup->directory_id) ?></td>
        <td><?= h($directoryGroup->directory_group_name) ?></td>
        <td><?= h($directoryGroup->directory_group_email) ?></td>
        <td><?= h($directoryGroup->directory_group_reference) ?></td>
    </tr>
    <?php endforeach; ?>
</tbody>
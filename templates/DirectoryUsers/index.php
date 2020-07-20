<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DirectoryUser[]|\Cake\Collection\CollectionInterface $directoryUsers
 */

$this->extend('../layout/CRUD/index');

$this->assign('entity', 'DirectoryUsers');
$this->assign('subset', 'All');
$this->assign('add', $this->Identity->checkCapability('CREATE_DIRECTORY_USER'));

?>
<thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
        <th scope="col"><?= $this->Paginator->sort('directory_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('directory_user_reference') ?></th>
        <th scope="col"><?= $this->Paginator->sort('given_name') ?></th>
        <th scope="col"><?= $this->Paginator->sort('family_name') ?></th>
        <th scope="col"><?= $this->Paginator->sort('primary_email') ?></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($directoryUsers as $directoryUser): ?>
    <tr>
        <td><?= h($directoryUser->id) ?></td>
                <td class="actions">
            <?= $this->Identity->checkCapability('VIEW_DIRECTORY_USER') ? $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $directoryUser->id], ['title' => __('View Directory User'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('UPDATE_DIRECTORY_USER') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $directoryUser->id], ['title' => __('Edit Directory User'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('DELETE_DIRECTORY_USER') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $directoryUser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $directoryUser->id), 'title' => __('Delete Directory User'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
        </td>
        <td><?= $this->Number->format($directoryUser->directory_id) ?></td>
        <td><?= h($directoryUser->directory_user_reference) ?></td>
        <td><?= h($directoryUser->given_name) ?></td>
        <td><?= h($directoryUser->family_name) ?></td>
        <td><?= h($directoryUser->primary_email) ?></td>
    </tr>
    <?php endforeach; ?>
</tbody>
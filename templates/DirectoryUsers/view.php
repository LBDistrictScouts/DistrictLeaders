<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DirectoryUser $directoryUser
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Directory User'), ['action' => 'edit', $directoryUser->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Directory User'), ['action' => 'delete', $directoryUser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $directoryUser->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Directory Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Directory User'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Directories'), ['controller' => 'Directories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Directory'), ['controller' => 'Directories', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="directoryUsers view large-9 medium-8 columns content">
    <h3><?= h($directoryUser->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Directory') ?></th>
            <td><?= $directoryUser->has('directory') ? $this->Html->link($directoryUser->directory->id, ['controller' => 'Directories', 'action' => 'view', $directoryUser->directory->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Directory User Reference') ?></th>
            <td><?= h($directoryUser->directory_user_reference) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Given Name') ?></th>
            <td><?= h($directoryUser->given_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Family Name') ?></th>
            <td><?= h($directoryUser->family_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Primary Email') ?></th>
            <td><?= h($directoryUser->primary_email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($directoryUser->id) ?></td>
        </tr>
    </table>
</div>

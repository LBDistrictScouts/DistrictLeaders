<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DirectoryDomain $directoryDomain
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Directory Domain'), ['action' => 'edit', $directoryDomain->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Directory Domain'), ['action' => 'delete', $directoryDomain->id], ['confirm' => __('Are you sure you want to delete # {0}?', $directoryDomain->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Directory Domains'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Directory Domain'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Directories'), ['controller' => 'Directories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Directory'), ['controller' => 'Directories', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="directoryDomains view large-9 medium-8 columns content">
    <h3><?= h($directoryDomain->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Directory Domain') ?></th>
            <td><?= h($directoryDomain->directory_domain) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Directory') ?></th>
            <td><?= $directoryDomain->has('directory') ? $this->Html->link($directoryDomain->directory->id, ['controller' => 'Directories', 'action' => 'view', $directoryDomain->directory->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($directoryDomain->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ingest') ?></th>
            <td><?= $directoryDomain->ingest ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>

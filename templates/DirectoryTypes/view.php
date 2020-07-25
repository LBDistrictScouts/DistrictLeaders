<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DirectoryType $directoryType
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Directory Type'), ['action' => 'edit', $directoryType->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Directory Type'), ['action' => 'delete', $directoryType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $directoryType->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Directory Types'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Directory Type'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Directories'), ['controller' => 'Directories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Directory'), ['controller' => 'Directories', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="directoryTypes view large-9 medium-8 columns content">
    <h3><?= h($directoryType->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Directory Type') ?></th>
            <td><?= h($directoryType->directory_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Directory Type Code') ?></th>
            <td><?= h($directoryType->directory_type_code) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($directoryType->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Directories') ?></h4>
        <?php if (!empty($directoryType->directories)) : ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Directory') ?></th>
                <th scope="col"><?= __('Configuration Payload') ?></th>
                <th scope="col"><?= __('Directory Type Id') ?></th>
                <th scope="col"><?= __('Active') ?></th>
                <th scope="col"><?= __('Customer Reference') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($directoryType->directories as $directories) : ?>
            <tr>
                <td><?= h($directories->id) ?></td>
                <td><?= h($directories->directory) ?></td>
                <td><?= h($directories->configuration_payload) ?></td>
                <td><?= h($directories->directory_type_id) ?></td>
                <td><?= h($directories->active) ?></td>
                <td><?= h($directories->customer_reference) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Directories', 'action' => 'view', $directories->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Directories', 'action' => 'edit', $directories->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Directories', 'action' => 'delete', $directories->id], ['confirm' => __('Are you sure you want to delete # {0}?', $directories->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>

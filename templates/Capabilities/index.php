<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Capability[]|\Cake\Collection\CollectionInterface $capabilities
 */

$this->extend('../Layout/CRUD/index');

$this->assign('entity', 'Capabilities');
$this->assign('subset', 'All');
$this->assign('add', $this->Identity->checkCapability('CREATE_CAPABILITY'));

?>
<thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('capability_code') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
        <th scope="col"><?= $this->Paginator->sort('capability') ?></th>
        <th scope="col"><?= $this->Paginator->sort('min_level') ?></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($capabilities as $capability): ?>
    <tr>
        <td><?= h($capability->capability_code) ?></td>
                <td class="actions">
            <?= $this->Identity->checkCapability('VIEW_CAPABILITY') ? $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $capability->id], ['title' => __('View Capability'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('UPDATE_CAPABILITY') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $capability->id], ['title' => __('Edit Capability'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('DELETE_CAPABILITY') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $capability->id], ['confirm' => __('Are you sure you want to delete # {0}?', $capability->id), 'title' => __('Delete Capability'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
        </td>
        <td><?= h($capability->capability) ?></td>
        <td><?= $this->Number->format($capability->min_level) ?></td>
    </tr>
    <?php endforeach; ?>
</tbody>
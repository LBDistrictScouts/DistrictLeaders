<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CampType $campType
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Camp Type'), ['action' => 'edit', $campType->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Camp Type'), ['action' => 'delete', $campType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $campType->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Camp Types'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Camp Type'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Camps'), ['controller' => 'Camps', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Camp'), ['controller' => 'Camps', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="campTypes view large-9 medium-8 columns content">
    <h3><?= h($campType->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Camp Type') ?></th>
            <td><?= h($campType->camp_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($campType->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Camps') ?></h4>
        <?php if (!empty($campType->camps)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Deleted') ?></th>
                <th scope="col"><?= __('Camp Name') ?></th>
                <th scope="col"><?= __('Camp Type Id') ?></th>
                <th scope="col"><?= __('Camp Start') ?></th>
                <th scope="col"><?= __('Camp End') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($campType->camps as $camps): ?>
            <tr>
                <td><?= h($camps->id) ?></td>
                <td><?= h($camps->created) ?></td>
                <td><?= h($camps->modified) ?></td>
                <td><?= h($camps->deleted) ?></td>
                <td><?= h($camps->camp_name) ?></td>
                <td><?= h($camps->camp_type_id) ?></td>
                <td><?= h($camps->camp_start) ?></td>
                <td><?= h($camps->camp_end) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Camps', 'action' => 'view', $camps->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Camps', 'action' => 'edit', $camps->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Camps', 'action' => 'delete', $camps->id], ['confirm' => __('Are you sure you want to delete # {0}?', $camps->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>

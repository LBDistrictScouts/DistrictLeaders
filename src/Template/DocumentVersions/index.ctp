<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DocumentVersion[]|\Cake\Collection\CollectionInterface $documentVersions
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Document Version'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Documents'), ['controller' => 'Documents', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Document'), ['controller' => 'Documents', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Document Editions'), ['controller' => 'DocumentEditions', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Document Edition'), ['controller' => 'DocumentEditions', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="documentVersions index large-9 medium-8 columns content">
    <h3><?= __('Document Versions') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('document_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('deleted') ?></th>
                <th scope="col"><?= $this->Paginator->sort('version_number') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($documentVersions as $documentVersion): ?>
            <tr>
                <td><?= $this->Number->format($documentVersion->id) ?></td>
                <td><?= $documentVersion->has('document') ? $this->Html->link($documentVersion->document->id, ['controller' => 'Documents', 'action' => 'view', $documentVersion->document->id]) : '' ?></td>
                <td><?= h($documentVersion->created) ?></td>
                <td><?= h($documentVersion->modified) ?></td>
                <td><?= h($documentVersion->deleted) ?></td>
                <td><?= $this->Number->format($documentVersion->version_number) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $documentVersion->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $documentVersion->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $documentVersion->id], ['confirm' => __('Are you sure you want to delete # {0}?', $documentVersion->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>

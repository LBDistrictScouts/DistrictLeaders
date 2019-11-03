<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DocumentEdition[]|\Cake\Collection\CollectionInterface $documentEditions
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Document Edition'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Document Versions'), ['controller' => 'DocumentVersions', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Document Version'), ['controller' => 'DocumentVersions', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List File Types'), ['controller' => 'FileTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New File Type'), ['controller' => 'FileTypes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="documentEditions index large-9 medium-8 columns content">
    <h3><?= __('Document Editions') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('deleted') ?></th>
                <th scope="col"><?= $this->Paginator->sort('document_version_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('file_type_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($documentEditions as $documentEdition): ?>
            <tr>
                <td><?= $this->Number->format($documentEdition->id) ?></td>
                <td><?= h($documentEdition->created) ?></td>
                <td><?= h($documentEdition->modified) ?></td>
                <td><?= h($documentEdition->deleted) ?></td>
                <td><?= $documentEdition->has('document_version') ? $this->Html->link($documentEdition->document_version->id, ['controller' => 'DocumentVersions', 'action' => 'view', $documentEdition->document_version->id]) : '' ?></td>
                <td><?= $documentEdition->has('file_type') ? $this->Html->link($documentEdition->file_type->id, ['controller' => 'FileTypes', 'action' => 'view', $documentEdition->file_type->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $documentEdition->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $documentEdition->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $documentEdition->id], ['confirm' => __('Are you sure you want to delete # {0}?', $documentEdition->id)]) ?>
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

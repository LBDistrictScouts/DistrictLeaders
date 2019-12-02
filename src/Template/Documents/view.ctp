<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Document $document
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Document'), ['action' => 'edit', $document->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Document'), ['action' => 'delete', $document->id], ['confirm' => __('Are you sure you want to delete # {0}?', $document->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Documents'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Document'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Document Types'), ['controller' => 'DocumentTypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Document Type'), ['controller' => 'DocumentTypes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Document Versions'), ['controller' => 'DocumentVersions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Document Version'), ['controller' => 'DocumentVersions', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="documents view large-9 medium-8 columns content">
    <h3><?= h($document->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Document Type') ?></th>
            <td><?= $document->has('document_type') ? $this->Html->link($document->document_type->id, ['controller' => 'DocumentTypes', 'action' => 'view', $document->document_type->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Document') ?></th>
            <td><?= h($document->document) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($document->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($document->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($document->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Deleted') ?></th>
            <td><?= h($document->deleted) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Document Versions') ?></h4>
        <?php if (!empty($document->document_versions)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Document Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Deleted') ?></th>
                <th scope="col"><?= __('Version Number') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($document->document_versions as $documentVersions): ?>
            <tr>
                <td><?= h($documentVersions->id) ?></td>
                <td><?= h($documentVersions->document_id) ?></td>
                <td><?= h($documentVersions->created) ?></td>
                <td><?= h($documentVersions->modified) ?></td>
                <td><?= h($documentVersions->deleted) ?></td>
                <td><?= h($documentVersions->version_number) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'DocumentVersions', 'action' => 'view', $documentVersions->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'DocumentVersions', 'action' => 'edit', $documentVersions->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'DocumentVersions', 'action' => 'delete', $documentVersions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $documentVersions->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>

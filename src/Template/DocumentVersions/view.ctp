<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DocumentVersion $documentVersion
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Document Version'), ['action' => 'edit', $documentVersion->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Document Version'), ['action' => 'delete', $documentVersion->id], ['confirm' => __('Are you sure you want to delete # {0}?', $documentVersion->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Document Versions'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Document Version'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Documents'), ['controller' => 'Documents', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Document'), ['controller' => 'Documents', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Document Editions'), ['controller' => 'DocumentEditions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Document Edition'), ['controller' => 'DocumentEditions', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="documentVersions view large-9 medium-8 columns content">
    <h3><?= h($documentVersion->version_number) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Document') ?></th>
            <td><?= $documentVersion->has('document') ? $this->Html->link($documentVersion->document->document, ['controller' => 'Documents', 'action' => 'view', $documentVersion->document->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($documentVersion->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Version Number') ?></th>
            <td><?= $this->Number->format($documentVersion->version_number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($documentVersion->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($documentVersion->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Deleted') ?></th>
            <td><?= h($documentVersion->deleted) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Document Editions') ?></h4>
        <?php if (!empty($documentVersion->document_editions)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Deleted') ?></th>
                <th scope="col"><?= __('Document Version Id') ?></th>
                <th scope="col"><?= __('File Type Id') ?></th>
                <th scope="col"><?= __('File Path') ?></th>
                <th scope="col"><?= __('Filename') ?></th>
                <th scope="col"><?= __('Size') ?></th>
                <th scope="col"><?= __('Md5 Hash') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($documentVersion->document_editions as $documentEditions): ?>
            <tr>
                <td><?= h($documentEditions->id) ?></td>
                <td><?= h($documentEditions->created) ?></td>
                <td><?= h($documentEditions->modified) ?></td>
                <td><?= h($documentEditions->deleted) ?></td>
                <td><?= h($documentEditions->document_version_id) ?></td>
                <td><?= h($documentEditions->file_type_id) ?></td>
                <td><?= h($documentEditions->file_path) ?></td>
                <td><?= h($documentEditions->filename) ?></td>
                <td><?= h($documentEditions->size) ?></td>
                <td><?= h($documentEditions->md5_hash) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'DocumentEditions', 'action' => 'view', $documentEditions->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'DocumentEditions', 'action' => 'edit', $documentEditions->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'DocumentEditions', 'action' => 'delete', $documentEditions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $documentEditions->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>

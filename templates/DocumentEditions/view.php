<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DocumentEdition $documentEdition
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Document Edition'), ['action' => 'edit', $documentEdition->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Document Edition'), ['action' => 'delete', $documentEdition->id], ['confirm' => __('Are you sure you want to delete # {0}?', $documentEdition->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Document Editions'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Document Edition'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Document Versions'), ['controller' => 'DocumentVersions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Document Version'), ['controller' => 'DocumentVersions', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List File Types'), ['controller' => 'FileTypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New File Type'), ['controller' => 'FileTypes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="documentEditions view large-9 medium-8 columns content">
    <h3><?= h($documentEdition->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Document Version') ?></th>
            <td><?= $documentEdition->has('document_version') ? $this->Html->link($documentEdition->document_version->version_number, ['controller' => 'DocumentVersions', 'action' => 'view', $documentEdition->document_version->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('File Type') ?></th>
            <td><?= $documentEdition->has('file_type') ? $this->Html->link($documentEdition->file_type->file_type, ['controller' => 'FileTypes', 'action' => 'view', $documentEdition->file_type->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('File Path') ?></th>
            <td><?= h($documentEdition->file_path) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Filename') ?></th>
            <td><?= h($documentEdition->filename) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Md5 Hash') ?></th>
            <td><?= h($documentEdition->md5_hash) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($documentEdition->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Size') ?></th>
            <td><?= $this->Number->format($documentEdition->size) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($documentEdition->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($documentEdition->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Deleted') ?></th>
            <td><?= h($documentEdition->deleted) ?></td>
        </tr>
    </table>
</div>

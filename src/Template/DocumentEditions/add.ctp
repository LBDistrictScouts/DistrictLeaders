<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DocumentEdition $documentEdition
 * @var mixed $documentVersions
 * @var mixed $fileTypes
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Document Editions'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Document Versions'), ['controller' => 'DocumentVersions', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Document Version'), ['controller' => 'DocumentVersions', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List File Types'), ['controller' => 'FileTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New File Type'), ['controller' => 'FileTypes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="documentEditions form large-9 medium-8 columns content">
    <?= $this->Form->create($documentEdition) ?>
    <fieldset>
        <legend><?= __('Add Document Edition') ?></legend>
        <?php
            echo $this->Form->control('deleted');
            echo $this->Form->control('document_version_id', ['options' => $documentVersions]);
            echo $this->Form->control('file_type_id', ['options' => $fileTypes]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

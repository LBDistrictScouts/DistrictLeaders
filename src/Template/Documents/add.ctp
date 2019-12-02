<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Document $document
 * @var mixed $documentTypes
 */

?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Documents'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Document Types'), ['controller' => 'DocumentTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Document Type'), ['controller' => 'DocumentTypes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Document Versions'), ['controller' => 'DocumentVersions', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Document Version'), ['controller' => 'DocumentVersions', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="documents form large-9 medium-8 columns content">
    <?= $this->Form->create($document) ?>
    <fieldset>
        <legend><?= __('Add Document') ?></legend>
        <?php
            echo $this->Form->control($document::FIELD_DOCUMENT, ['label' => 'Document Name']);
            echo $this->Form->control($document::FIELD_DOCUMENT_TYPE_ID, ['options' => $documentTypes]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DocumentVersion $documentVersion
 * @var mixed $documents
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $documentVersion->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $documentVersion->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Document Versions'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Documents'), ['controller' => 'Documents', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Document'), ['controller' => 'Documents', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Document Editions'), ['controller' => 'DocumentEditions', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Document Edition'), ['controller' => 'DocumentEditions', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="documentVersions form large-9 medium-8 columns content">
    <?= $this->Form->create($documentVersion) ?>
    <fieldset>
        <legend><?= __('Edit Document Version') ?></legend>
        <?php
            echo $this->Form->control('document_id', ['options' => $documents]);
            echo $this->Form->control('deleted');
            echo $this->Form->control('version_number');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

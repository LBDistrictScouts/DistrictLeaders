<?php
/**
 * @var AppView $this
 * @var DocumentType $documentType
 */

use App\Model\Entity\DocumentType;
use App\View\AppView;

?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
            __('Delete'),
            ['action' => 'delete', $documentType->id],
            ['confirm' => __('Are you sure you want to delete # {0}?', $documentType->id)]
        )
                            ?></li>
        <li><?= $this->Html->link(__('List Document Types'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Documents'), ['controller' => 'Documents', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Document'), ['controller' => 'Documents', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="documentTypes form large-9 medium-8 columns content">
    <?= $this->Form->create($documentType) ?>
    <fieldset>
        <legend><?= __('Edit Document Type') ?></legend>
        <?php
            echo $this->Form->control('document_type');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>

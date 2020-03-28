<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Document $document
 * @var mixed $documentTypes
 */

$this->extend('../Layout/CRUD/edit');

$this->assign('entity', 'Documents');

?>
<?= $this->Form->create($document) ?>
<fieldset>
    <?php
        /** @var array $documentTypes The Document Type Id List */
        echo $this->Form->control($document::FIELD_DOCUMENT_TYPE_ID, ['options' => $documentTypes]);
        echo $this->Form->control($document::FIELD_DOCUMENT);
    ?>
</fieldset>
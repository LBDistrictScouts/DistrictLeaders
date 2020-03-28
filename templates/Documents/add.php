<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Document $document
 * @var mixed $documentTypes
 */

$this->extend('../Layout/CRUD/add');

$this->assign('entity', 'Documents');

?>
<?= $this->Form->create($document, ['enctype' => 'multipart/form-data']) ?>
<fieldset>
    <?php
        echo $this->Form->control('uploadedFile', ['type' => 'file']);
        echo $this->Form->control($document::FIELD_DOCUMENT_TYPE_ID, ['options' => $documentTypes]);
    ?>
</fieldset>

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DocumentEdition $documentEdition
 * @var mixed $documentVersions
 * @var mixed $fileTypes
 */

$this->extend('../Layout/CRUD/add');

$this->assign('entity', 'DocumentEditions');

?>
<?= $this->Form->create($documentEdition, ['enctype' => 'multipart/form-data']) ?>
<fieldset>
    <?php
        echo $this->Form->control('uploadedFile', ['type' => 'file']);
        echo $this->Form->control('document_version_id', ['options' => $documentVersions]);
    ?>
</fieldset>

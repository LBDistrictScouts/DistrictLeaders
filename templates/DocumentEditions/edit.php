<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DocumentEdition $documentEdition
 * @var mixed $documentVersions
 * @var mixed $fileTypes
 */

$this->extend('../layout/CRUD/edit');

$this->assign('entity', 'DocumentEditions');
?>
<?= $this->Form->create($documentEdition) ?>
<fieldset>
    <?php
        /** @var array $documentVersions The Document Version Id List */
        echo $this->Form->control($documentEdition::FIELD_DOCUMENT_VERSION_ID, ['options' => $documentVersions]);
        /** @var array $fileTypes The File Type Id List */
        echo $this->Form->control($documentEdition::FIELD_FILE_TYPE_ID, ['options' => $fileTypes]);
        echo $this->Form->control($documentEdition::FIELD_FILE_PATH);
        echo $this->Form->control($documentEdition::FIELD_FILENAME);
        echo $this->Form->control($documentEdition::FIELD_SIZE);
        echo $this->Form->control($documentEdition::FIELD_MD5_HASH);
    ?>
</fieldset>

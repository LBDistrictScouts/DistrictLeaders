<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DocumentVersion $documentVersion
 * @var mixed $documents
 */

$this->extend('../Layout/CRUD/add');

$this->assign('entity', 'DocumentVersions');
?>
<?= $this->Form->create($documentVersion) ?>
<fieldset>
    <?php
        /** @var array $documents The Document Id List */
        echo $this->Form->control($documentVersion::FIELD_DOCUMENT_ID, ['options' => $documents]);
        echo $this->Form->control($documentVersion::FIELD_VERSION_NUMBER);
    ?>
</fieldset>
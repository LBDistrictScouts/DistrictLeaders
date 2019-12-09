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
        echo $this->Form->control('document_id', ['options' => $documents]);
        echo $this->Form->control('version_number');
    ?>
</fieldset>

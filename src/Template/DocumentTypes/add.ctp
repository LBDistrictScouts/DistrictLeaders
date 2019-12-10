<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DocumentType $documentType
 */


$this->extend('../Layout/CRUD/add');

$this->assign('entity', 'DocumentTypes');
?>
<?= $this->Form->create($documentType) ?>
<fieldset>
    <?php
        echo $this->Form->control('document_type', ['default' => '']);
    ?>
</fieldset>


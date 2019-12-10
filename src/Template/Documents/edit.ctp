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
        echo $this->Form->control('document_type_id', ['options' => $documentTypes]);
        echo $this->Form->control('document');
    ?>
</fieldset>

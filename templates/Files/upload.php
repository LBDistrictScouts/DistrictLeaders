<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Form\FileForm $fileForm
 */

$this->extend('../Layout/CRUD/add');

$this->assign('entity', 'Files');
$this->assign('icon', 'fa-file');

?>
<?= $this->Form->create($fileForm, ['type' => 'file']) ?>
<fieldset>
    <?php
    echo $this->Form->file('file');
    ?>
</fieldset>


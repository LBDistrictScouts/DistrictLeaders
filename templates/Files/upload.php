<?php
/**
 * @var AppView $this
 * @var FileForm $fileForm
 */

use App\Form\FileForm;
use App\View\AppView;

$this->extend('../layout/CRUD/add');

$this->assign('entity', 'Files');
$this->assign('icon', 'fa-file');

?>
<?= $this->Form->create($fileForm, ['type' => 'file']) ?>
<fieldset>
    <?php
    echo $this->Form->file('file');
    ?>
</fieldset>


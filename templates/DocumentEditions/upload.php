<?php
/**
 * @var AppView $this
 * @var DocumentEdition $documentEdition
 * @var mixed $documentVersions
 * @var mixed $fileTypes
 */

use App\Model\Entity\DocumentEdition;
use App\View\AppView;

$this->extend('../layout/CRUD/add');

$this->assign('entity', 'DocumentEditions');

?>
<?= $this->Form->create($documentEdition, ['enctype' => 'multipart/form-data']) ?>
<fieldset>
    <?php
        echo $this->Form->control('uploadedFile', ['type' => 'file']);
        echo $this->Form->control('document_version_id', ['options' => $documentVersions]);
    ?>
</fieldset>

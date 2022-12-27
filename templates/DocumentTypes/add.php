<?php
/**
 * @var AppView $this
 * @var DocumentType $documentType
 */

use App\Model\Entity\DocumentType;
use App\View\AppView;

$this->extend('../layout/CRUD/add');

$this->assign('entity', 'DocumentTypes');
?>
<?= $this->Form->create($documentType) ?>
<fieldset>
    <?php
        echo $this->Form->control('document_type', ['default' => '']);
    ?>
</fieldset>


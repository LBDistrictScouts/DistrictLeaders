<?php
/**
 * @var AppView $this
 * @var Document $document
 * @var mixed $documentTypes
 */

use App\Model\Entity\Document;
use App\View\AppView;

$this->extend('../layout/CRUD/edit');

$this->assign('entity', 'Documents');

?>
<?= $this->Form->create($document) ?>
<fieldset>
    <?php
        /** @var array $documentTypes The Document Type Id List */
        echo $this->Form->control($document::FIELD_DOCUMENT_TYPE_ID, ['options' => $documentTypes]);
        echo $this->Form->control($document::FIELD_DOCUMENT);
    ?>
</fieldset>

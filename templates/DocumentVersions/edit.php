<?php
/**
 * @var AppView $this
 * @var DocumentVersion $documentVersion
 * @var mixed $documents
 */

use App\Model\Entity\DocumentVersion;
use App\View\AppView;

$this->extend('../layout/CRUD/edit');

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

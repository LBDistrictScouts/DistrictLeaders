<?php
/**
 * @var AppView $this
 * @var Document $document
 * @var mixed $documentTypes
 * @var string $term
 * @var DocumentType $documentType
 */

use App\Model\Entity\Document;
use App\Model\Entity\DocumentType;
use App\View\AppView;

$this->extend('../layout/CRUD/add');

$this->assign('entity', $term);

?>
<?= $this->Form->create($document, ['enctype' => 'multipart/form-data']) ?>
<fieldset>
    <?php
    $args = [
        'CHANGE',
        $document->getSource(),
        null,
        null,
    ];

    $args[4] = $document::FIELD_DOCUMENT;
    echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control('uploadedFile', ['type' => 'file', 'label' => $term]) : '';

    $args[4] = $document::FIELD_DOCUMENT_TYPE_ID;
    if (isset($documentTypes)) {
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($document::FIELD_DOCUMENT_TYPE_ID, ['options' => $documentTypes]) : '';
    }
    ?>
</fieldset>

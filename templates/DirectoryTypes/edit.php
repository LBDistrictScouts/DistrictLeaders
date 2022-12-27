<?php
/**
 * @var AppView $this
 * @var DirectoryType $directoryType
 */

use App\Model\Entity\DirectoryType;
use App\View\AppView;

$this->extend('../layout/CRUD/edit');

$this->assign('entity', 'DirectoryTypes');
?>
<?= $this->Form->create($directoryType) ?>
<fieldset>
    <?php
        $args = [
            'CHANGE',
            $directoryType->getSource(),
            null,
            null,
        ];

        $args[4] = $directoryType::FIELD_ID;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($directoryType::FIELD_ID) : '';

        $args[4] = $directoryType::FIELD_DIRECTORY_TYPE;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($directoryType::FIELD_DIRECTORY_TYPE) : '';

        $args[4] = $directoryType::FIELD_DIRECTORY_TYPE_CODE;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($directoryType::FIELD_DIRECTORY_TYPE_CODE) : '';

        ?>
</fieldset>

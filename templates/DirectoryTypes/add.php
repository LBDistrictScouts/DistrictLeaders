<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DirectoryType $directoryType
 */

$this->extend('../layout/CRUD/add');

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
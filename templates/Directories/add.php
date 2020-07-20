<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Directory $directory
 * @var mixed $directoryTypes
 */

$this->extend('../layout/CRUD/add');

$this->assign('entity', 'Directories');
?>
<?= $this->Form->create($directory) ?>
<fieldset>
    <?php
        $args = [
            'CHANGE',
            $directory->getSource(),
            null,
            null,
        ];

        $args[4] = $directory::FIELD_ID;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($directory::FIELD_ID) : '';

        $args[4] = $directory::FIELD_DIRECTORY;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($directory::FIELD_DIRECTORY) : '';

        $args[4] = $directory::FIELD_CONFIGURATION_PAYLOAD;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($directory::FIELD_CONFIGURATION_PAYLOAD) : '';

        $args[4] = $directory::FIELD_DIRECTORY_TYPE_ID;
        /** @var array $directoryTypes The Directory Type Id List */
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($directory::FIELD_DIRECTORY_TYPE_ID, ['options' => $directoryTypes]) : '';

        $args[4] = $directory::FIELD_ACTIVE;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($directory::FIELD_ACTIVE) : '';

        $args[4] = $directory::FIELD_CUSTOMER_REFERENCE;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($directory::FIELD_CUSTOMER_REFERENCE) : '';

    ?>
</fieldset>
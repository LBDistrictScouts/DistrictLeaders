<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DirectoryGroup $directoryGroup
 * @var mixed $directories
 * @var mixed $roleTypes
 */

$this->extend('../layout/CRUD/add');

$this->assign('entity', 'DirectoryGroups');
?>
<?= $this->Form->create($directoryGroup) ?>
<fieldset>
    <?php
        $args = [
            'CHANGE',
            $directoryGroup->getSource(),
            null,
            null,
        ];

        $args[4] = $directoryGroup::FIELD_ID;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($directoryGroup::FIELD_ID) : '';

        $args[4] = $directoryGroup::FIELD_DIRECTORY_ID;
        /** @var array $directories The Directory Id List */
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($directoryGroup::FIELD_DIRECTORY_ID, ['options' => $directories]) : '';

        $args[4] = $directoryGroup::FIELD_DIRECTORY_GROUP_NAME;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($directoryGroup::FIELD_DIRECTORY_GROUP_NAME) : '';

        $args[4] = $directoryGroup::FIELD_DIRECTORY_GROUP_EMAIL;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($directoryGroup::FIELD_DIRECTORY_GROUP_EMAIL) : '';

        $args[4] = $directoryGroup::FIELD_DIRECTORY_GROUP_REFERENCE;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($directoryGroup::FIELD_DIRECTORY_GROUP_REFERENCE) : '';

        /** @var array $roleTypes The RoleTypes List */
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control('role_types._ids', ['options' => $roleTypes]) : '';
    ?>
</fieldset>
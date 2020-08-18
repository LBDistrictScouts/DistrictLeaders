<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Capability $capability
 * @var mixed $roleTypes
 */

$this->extend('../layout/CRUD/edit');

$this->assign('entity', 'Capabilities');
?>
<?= $this->Form->create($capability) ?>
<fieldset>
    <?php
        $args = [
            'CHANGE',
            $capability->getSource(),
            null,
            null,
        ];

        $args[4] = $capability::FIELD_CAPABILITY_CODE;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($capability::FIELD_CAPABILITY_CODE) : '';

        $args[4] = $capability::FIELD_CAPABILITY;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($capability::FIELD_CAPABILITY) : '';

        $args[4] = $capability::FIELD_MIN_LEVEL;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($capability::FIELD_MIN_LEVEL) : '';

        /** @var array $roleTypes The RoleTypes List */
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control('role_types._ids', ['options' => $roleTypes, 'multiple' => 'checkbox']) : '';
        ?>
</fieldset>

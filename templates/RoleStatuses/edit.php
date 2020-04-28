<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RoleStatus $roleStatus
 */

$this->extend('../layout/CRUD/edit');

$this->assign('entity', 'RoleStatuses');
?>
<?= $this->Form->create($roleStatus) ?>
<fieldset>
    <?php
        $args = [
            'CHANGE',
            $roleStatus->getSource(),
            null,
            null,
        ];

        $args[4] = $roleStatus::FIELD_ID;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($roleStatus::FIELD_ID) : '';

        $args[4] = $roleStatus::FIELD_ROLE_STATUS;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($roleStatus::FIELD_ROLE_STATUS) : '';

    ?>
</fieldset>

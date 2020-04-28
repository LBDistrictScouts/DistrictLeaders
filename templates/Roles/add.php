<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Role $role
 * @var mixed $roleStatuses
 * @var mixed $roleTypes
 * @var mixed $sections
 * @var mixed $users
 */

$this->extend('../layout/CRUD/add');

$this->assign('entity', 'Roles');
?>
<?= $this->Form->create($role) ?>
<fieldset>
    <?php
        $args = [
            'CHANGE',
            $role->getSource(),
            null,
            null,
        ];

        $args[4] = $role::FIELD_ID;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($role::FIELD_ID) : '';

        $args[4] = $role::FIELD_ROLE_TYPE_ID;
        /** @var array $roleTypes The Role Type Id List */
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($role::FIELD_ROLE_TYPE_ID, ['options' => $roleTypes]) : '';

        $args[4] = $role::FIELD_SECTION_ID;
        /** @var array $sections The Section Id List */
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($role::FIELD_SECTION_ID, ['options' => $sections]) : '';

        $args[4] = $role::FIELD_USER_ID;
        /** @var array $users The User Id List */
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($role::FIELD_USER_ID, ['options' => $users]) : '';

        $args[4] = $role::FIELD_ROLE_STATUS_ID;
        /** @var array $roleStatuses The Role Status Id List */
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($role::FIELD_ROLE_STATUS_ID, ['options' => $roleStatuses]) : '';

        ?>
</fieldset>

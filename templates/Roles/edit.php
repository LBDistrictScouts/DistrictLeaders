<?php
/**
 * @var \App\View\AppView $this
 * @var bool $contact
 * @var \App\Model\Entity\Role $role
 */

$this->extend('../Layout/CRUD/edit');

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

        if (!$contact) {
            $args[4] = $role::FIELD_ROLE_TYPE_ID;
            /** @var array $roleTypes The Role Type Id List */
            echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($role::FIELD_ROLE_TYPE_ID, ['options' => $roleTypes]) : '';

            $args[4] = $role::FIELD_SECTION_ID;
            /** @var array $sections The Section Id List */
            echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($role::FIELD_SECTION_ID, ['options' => $sections]) : '';

            $args[4] = $role::FIELD_ROLE_STATUS_ID;
            /** @var array $roleStatuses The Role Status Id List */
            echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($role::FIELD_ROLE_STATUS_ID, ['options' => $roleStatuses]) : '';
        }

        $args[4] = $role::FIELD_USER_CONTACT_ID;
        /** @var array $userContacts The User Contact Id List */
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($role::FIELD_USER_CONTACT_ID, ['options' => $userContacts, 'empty' => true]) : '';

    ?>
</fieldset>

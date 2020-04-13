<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CampRole $campRole
 * @var mixed $campRoleTypes
 * @var mixed $camps
 * @var mixed $users
 */

$this->extend('../Layout/CRUD/add');

$this->assign('entity', 'CampRoles');
?>
<?= $this->Form->create($campRole) ?>
<fieldset>
    <?php
        $args = [
            'CHANGE',
            $campRole->getSource(),
            null,
            null,
        ];

        $args[4] = $campRole::FIELD_ID;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($campRole::FIELD_ID) : '';

        $args[4] = $campRole::FIELD_CAMP_ID;
        /** @var array $camps The Camp Id List */
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($campRole::FIELD_CAMP_ID, ['options' => $camps]) : '';

        $args[4] = $campRole::FIELD_USER_ID;
        /** @var array $users The User Id List */
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($campRole::FIELD_USER_ID, ['options' => $users]) : '';

        $args[4] = $campRole::FIELD_CAMP_ROLE_TYPE_ID;
        /** @var array $campRoleTypes The Camp Role Type Id List */
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($campRole::FIELD_CAMP_ROLE_TYPE_ID, ['options' => $campRoleTypes]) : '';

    ?>
</fieldset>
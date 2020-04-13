<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CampRoleType $campRoleType
 */

$this->extend('../Layout/CRUD/edit');

$this->assign('entity', 'CampRoleTypes');
?>
<?= $this->Form->create($campRoleType) ?>
<fieldset>
    <?php
        $args = [
            'CHANGE',
            $campRoleType->getSource(),
            null,
            null,
        ];

        $args[4] = $campRoleType::FIELD_ID;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($campRoleType::FIELD_ID) : '';

        $args[4] = $campRoleType::FIELD_CAMP_ROLE_TYPE;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($campRoleType::FIELD_CAMP_ROLE_TYPE) : '';

    ?>
</fieldset>
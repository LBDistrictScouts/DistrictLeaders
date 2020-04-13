<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RoleType $roleType
 */

$this->extend('../Layout/CRUD/edit');

$this->assign('entity', 'RoleTypes');
?>
<?= $this->Form->create($roleType) ?>
<fieldset>
    <?php
        $args = [
            'CHANGE',
            $roleType->getSource(),
            null,
            null,
        ];

        $args[4] = $roleType::FIELD_ID;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($roleType::FIELD_ID) : '';

        $args[4] = $roleType::FIELD_ROLE_TYPE;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($roleType::FIELD_ROLE_TYPE) : '';

        $args[4] = $roleType::FIELD_ROLE_ABBREVIATION;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($roleType::FIELD_ROLE_ABBREVIATION) : '';

        $args[4] = $roleType::FIELD_SECTION_TYPE_ID;
        /** @var array $sectionTypes The Section Type Id List */
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($roleType::FIELD_SECTION_TYPE_ID, ['options' => $sectionTypes, 'empty' => true]) : '';

        $args[4] = $roleType::FIELD_LEVEL;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($roleType::FIELD_LEVEL) : '';

        $args[4] = $roleType::FIELD_ROLE_TEMPLATE_ID;
        /** @var array $roleTemplates The Role Template Id List */
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($roleType::FIELD_ROLE_TEMPLATE_ID, ['options' => $roleTemplates, 'empty' => true]) : '';

        /** @var array $capabilities The Capabilities List */
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control('capabilities._ids', ['options' => $capabilities]) : '';
    ?>
</fieldset>
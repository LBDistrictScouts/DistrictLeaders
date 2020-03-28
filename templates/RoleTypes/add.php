<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RoleType $roleType
 * @var mixed $capabilities
 * @var mixed $roleTemplates
 * @var mixed $sectionTypes
 */

$this->extend('../Layout/CRUD/add');

$this->assign('entity', 'RoleTypes');
?>
<?= $this->Form->create($roleType) ?>
<fieldset>
    <?php
        echo $this->Form->control($roleType::FIELD_ROLE_TYPE);
        echo $this->Form->control($roleType::FIELD_ROLE_ABBREVIATION);
        /** @var array $sectionTypes The Section Type Id List */
        echo $this->Form->control($roleType::FIELD_SECTION_TYPE_ID, ['options' => $sectionTypes, 'empty' => true]);
        echo $this->Form->control($roleType::FIELD_LEVEL);
        /** @var array $roleTemplates The Role Template Id List */
        echo $this->Form->control($roleType::FIELD_ROLE_TEMPLATE_ID, ['options' => $roleTemplates, 'empty' => true]);
        /** @var array $capabilities The Capabilities List */
        echo $this->Form->control('capabilities._ids', ['options' => $capabilities]);
    ?>
</fieldset>
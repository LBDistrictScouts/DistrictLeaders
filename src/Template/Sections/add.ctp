<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Section $section
 * @var mixed $scoutGroups
 * @var mixed $sectionTypes
 */

$this->extend('../Layout/CRUD/add');

$this->assign('entity', 'Sections');
?>
<?= $this->Form->create($section) ?>
<fieldset>
    <?php
        echo $this->Form->control($section::FIELD_SECTION);
        /** @var array $sectionTypes The Section Type Id List */
        echo $this->Form->control($section::FIELD_SECTION_TYPE_ID, ['options' => $sectionTypes]);
        /** @var array $scoutGroups The Scout Group Id List */
        echo $this->Form->control($section::FIELD_SCOUT_GROUP_ID, ['options' => $scoutGroups]);
    ?>
</fieldset>
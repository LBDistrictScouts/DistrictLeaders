<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SectionType $sectionType
 */

$this->extend('../layout/CRUD/add');

$this->assign('entity', 'SectionTypes');
?>
<?= $this->Form->create($sectionType) ?>
<fieldset>
    <?php
        echo $this->Form->control($sectionType::FIELD_SECTION_TYPE);
        echo $this->Form->control($sectionType::FIELD_SECTION_TYPE_CODE);
    ?>
</fieldset>

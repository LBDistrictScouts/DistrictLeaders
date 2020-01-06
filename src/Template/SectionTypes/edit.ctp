<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SectionType $sectionType
 */

$this->extend('../Layout/CRUD/edit');

$this->assign('entity', 'SectionTypes');
?>
<?= $this->Form->create($sectionType) ?>
<fieldset>
    <?php
        echo $this->Form->control($sectionType::FIELD_SECTION_TYPE);
    ?>
</fieldset>
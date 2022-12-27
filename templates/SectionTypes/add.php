<?php
/**
 * @var AppView $this
 * @var SectionType $sectionType
 */

use App\Model\Entity\SectionType;
use App\View\AppView;

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

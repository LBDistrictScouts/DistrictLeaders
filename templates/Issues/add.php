<?php
/**
 * @var AppView $this
 * @var Camp $camp
 *
 * @var array $campTypes
 */

use App\Model\Entity\Camp;
use App\View\AppView;

$this->extend('../layout/CRUD/add');

$this->assign('entity', 'Camps');

?>
<?= $this->Form->create($camp) ?>
<fieldset>
    <?php
        echo $this->Form->control($camp::FIELD_CAMP_NAME);
        echo $this->Form->control($camp::FIELD_CAMP_TYPE_ID, ['options' => $campTypes]);
        echo $this->Form->control($camp::FIELD_CAMP_START, ['class' => 'datetime']);
        echo $this->Form->control($camp::FIELD_CAMP_END);
    ?>
</fieldset>


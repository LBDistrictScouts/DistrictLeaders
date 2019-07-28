<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Camp $camp
 *
 * @var array $campTypes
 */

$this->extend('../Layout/CRUD/add');

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


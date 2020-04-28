<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ScoutGroup $scoutGroup
 */

$this->extend('../layout/CRUD/edit');

$this->assign('entity', 'ScoutGroups');
?>
<?= $this->Form->create($scoutGroup) ?>
<fieldset>
    <?php
        echo $this->Form->control($scoutGroup::FIELD_SCOUT_GROUP);
        echo $this->Form->control($scoutGroup::FIELD_GROUP_ALIAS);
        echo $this->Form->control($scoutGroup::FIELD_NUMBER_STRIPPED);
        echo $this->Form->control($scoutGroup::FIELD_CHARITY_NUMBER);
        echo $this->Form->control($scoutGroup::FIELD_GROUP_DOMAIN);
    ?>
</fieldset>

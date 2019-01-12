<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ScoutGroup $scoutGroup
 */

$this->extend('../Layout/CRUD/add');

$this->assign('entity', 'ScoutGroups');
$this->assign('icon', 'fa-paw');

?>
<?= $this->Form->create($scoutGroup) ?>
<fieldset>
    <?php
        echo $this->Form->control('scout_group');
        echo $this->Form->control('group_alias');
        echo $this->Form->control('number_stripped');
        echo $this->Form->control('charity_number');
        echo $this->Form->control('group_domain');
    ?>
</fieldset>


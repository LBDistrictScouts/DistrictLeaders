<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ScoutGroup $scoutGroup
 */

$this->extend('../layout/CRUD/add');

$this->assign('entity', 'ScoutGroups');
?>
<?= $this->Form->create($scoutGroup) ?>
<fieldset>
    <?php
        $args = [
            'CREATE',
            $scoutGroup->getSource(),
            null,
            null,
        ];

        $args[4] = $scoutGroup::FIELD_SCOUT_GROUP;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($scoutGroup::FIELD_SCOUT_GROUP) : '';

        $args[4] = $scoutGroup::FIELD_GROUP_ALIAS;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($scoutGroup::FIELD_GROUP_ALIAS) : '';

        $args[4] = $scoutGroup::FIELD_NUMBER_STRIPPED;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($scoutGroup::FIELD_NUMBER_STRIPPED) : '';

        $args[4] = $scoutGroup::FIELD_CHARITY_NUMBER;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($scoutGroup::FIELD_CHARITY_NUMBER) : '';

        $args[4] = $scoutGroup::FIELD_GROUP_DOMAIN;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($scoutGroup::FIELD_GROUP_DOMAIN) : '';

        $args[4] = $scoutGroup::FIELD_PUBLIC;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($scoutGroup::FIELD_PUBLIC) : '';
        ?>
</fieldset>

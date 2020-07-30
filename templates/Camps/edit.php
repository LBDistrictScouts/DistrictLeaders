<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Camp $camp
 * @var mixed $campTypes
 */

$this->extend('../layout/CRUD/edit');

$this->assign('entity', 'Camps');
?>
<?= $this->Form->create($camp) ?>
<fieldset>
    <?php
        $args = [
            'CHANGE',
            $camp->getSource(),
            null,
            null,
        ];

        $args[4] = $camp::FIELD_ID;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($camp::FIELD_ID) : '';

        $args[4] = $camp::FIELD_CAMP_NAME;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($camp::FIELD_CAMP_NAME) : '';

        $args[4] = $camp::FIELD_CAMP_TYPE_ID;
        /** @var array $campTypes The Camp Type Id List */
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($camp::FIELD_CAMP_TYPE_ID, ['options' => $campTypes]) : '';

        $args[4] = $camp::FIELD_CAMP_START;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($camp::FIELD_CAMP_START) : '';

        $args[4] = $camp::FIELD_CAMP_END;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($camp::FIELD_CAMP_END) : '';

        ?>
</fieldset>
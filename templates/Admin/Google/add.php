<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CampType $campType
 */

$this->extend('../layout/CRUD/add');

$this->assign('entity', 'CampTypes');
?>
<?= $this->Form->create($campType) ?>
<fieldset>
    <?php
        $args = [
            'CHANGE',
            $campType->getSource(),
            null,
            null,
        ];

        $args[4] = $campType::FIELD_ID;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($campType::FIELD_ID) : '';

        $args[4] = $campType::FIELD_CAMP_TYPE;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($campType::FIELD_CAMP_TYPE) : '';

        ?>
</fieldset>

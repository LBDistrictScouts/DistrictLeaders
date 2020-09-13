<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CompassRecord $compassRecord
 * @var mixed $documentVersions
 */

$this->extend('../layout/CRUD/edit');

$this->assign('entity', 'CompassRecords');
?>
<?= $this->Form->create($compassRecord) ?>
<fieldset>
    <?php
        $args = [
            'CHANGE',
            $compassRecord->getSource(),
            null,
            null,
        ];

        $args[4] = $compassRecord::FIELD_MEMBERSHIP_NUMBER;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($compassRecord::FIELD_MEMBERSHIP_NUMBER) : '';

        $args[4] = $compassRecord::FIELD_TITLE;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($compassRecord::FIELD_TITLE) : '';

        $args[4] = $compassRecord::FIELD_FORENAMES;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($compassRecord::FIELD_FORENAMES) : '';

        $args[4] = $compassRecord::FIELD_SURNAME;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($compassRecord::FIELD_SURNAME) : '';

        $args[4] = $compassRecord::FIELD_ADDRESS;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($compassRecord::FIELD_ADDRESS) : '';

        $args[4] = $compassRecord::FIELD_ADDRESS_LINE1;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($compassRecord::FIELD_ADDRESS_LINE1) : '';

        $args[4] = $compassRecord::FIELD_ADDRESS_LINE2;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($compassRecord::FIELD_ADDRESS_LINE2) : '';

        $args[4] = $compassRecord::FIELD_ADDRESS_LINE3;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($compassRecord::FIELD_ADDRESS_LINE3) : '';

        $args[4] = $compassRecord::FIELD_ADDRESS_TOWN;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($compassRecord::FIELD_ADDRESS_TOWN) : '';

        $args[4] = $compassRecord::FIELD_ADDRESS_COUNTY;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($compassRecord::FIELD_ADDRESS_COUNTY) : '';

        $args[4] = $compassRecord::FIELD_POSTCODE;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($compassRecord::FIELD_POSTCODE) : '';

        $args[4] = $compassRecord::FIELD_ADDRESS_COUNTRY;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($compassRecord::FIELD_ADDRESS_COUNTRY) : '';

        $args[4] = $compassRecord::FIELD_ROLE;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($compassRecord::FIELD_ROLE) : '';

        $args[4] = $compassRecord::FIELD_LOCATION;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($compassRecord::FIELD_LOCATION) : '';

        $args[4] = $compassRecord::FIELD_PHONE;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($compassRecord::FIELD_PHONE) : '';

        $args[4] = $compassRecord::FIELD_EMAIL;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($compassRecord::FIELD_EMAIL) : '';

        ?>
</fieldset>

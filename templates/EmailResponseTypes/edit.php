<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmailResponseType $emailResponseType
 */

$this->extend('../layout/CRUD/edit');

$this->assign('entity', 'EmailResponseTypes');
?>
<?= $this->Form->create($emailResponseType) ?>
<fieldset>
    <?php
        $args = [
            'CHANGE',
            $emailResponseType->getSource(),
            null,
            null,
        ];

        $args[4] = $emailResponseType::FIELD_ID;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($emailResponseType::FIELD_ID) : '';

        $args[4] = $emailResponseType::FIELD_EMAIL_RESPONSE_TYPE;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($emailResponseType::FIELD_EMAIL_RESPONSE_TYPE) : '';

        $args[4] = $emailResponseType::FIELD_BOUNCE;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($emailResponseType::FIELD_BOUNCE) : '';

        ?>
</fieldset>

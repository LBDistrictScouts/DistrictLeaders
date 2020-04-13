<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmailSend $emailSend
 * @var mixed $notifications
 * @var mixed $users
 */

$this->extend('../Layout/CRUD/add');

$this->assign('entity', 'EmailSends');
?>
<?= $this->Form->create($emailSend) ?>
<fieldset>
    <?php
        $args = [
            'CHANGE',
            $emailSend->getSource(),
            null,
            null,
        ];

        $args[4] = $emailSend::FIELD_ID;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($emailSend::FIELD_ID) : '';

        $args[4] = $emailSend::FIELD_EMAIL_GENERATION_CODE;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($emailSend::FIELD_EMAIL_GENERATION_CODE) : '';

        $args[4] = $emailSend::FIELD_EMAIL_TEMPLATE;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($emailSend::FIELD_EMAIL_TEMPLATE) : '';

        $args[4] = $emailSend::FIELD_INCLUDE_TOKEN;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($emailSend::FIELD_INCLUDE_TOKEN) : '';

        $args[4] = $emailSend::FIELD_SENT;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($emailSend::FIELD_SENT) : '';

        $args[4] = $emailSend::FIELD_MESSAGE_SEND_CODE;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($emailSend::FIELD_MESSAGE_SEND_CODE) : '';

        $args[4] = $emailSend::FIELD_USER_ID;
        /** @var array $users The User Id List */
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($emailSend::FIELD_USER_ID, ['options' => $users, 'empty' => true]) : '';

        $args[4] = $emailSend::FIELD_SUBJECT;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($emailSend::FIELD_SUBJECT) : '';

        $args[4] = $emailSend::FIELD_ROUTING_DOMAIN;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($emailSend::FIELD_ROUTING_DOMAIN) : '';

        $args[4] = $emailSend::FIELD_FROM_ADDRESS;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($emailSend::FIELD_FROM_ADDRESS) : '';

        $args[4] = $emailSend::FIELD_FRIENDLY_FROM;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($emailSend::FIELD_FRIENDLY_FROM) : '';

        $args[4] = $emailSend::FIELD_NOTIFICATION_ID;
        /** @var array $notifications The Notification Id List */
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($emailSend::FIELD_NOTIFICATION_ID, ['options' => $notifications, 'empty' => true]) : '';

    ?>
</fieldset>
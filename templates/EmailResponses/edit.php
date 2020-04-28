<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmailResponse $emailResponse
 * @var mixed $emailResponseTypes
 * @var mixed $emailSends
 */

$this->extend('../layout/CRUD/edit');

$this->assign('entity', 'EmailResponses');
?>
<?= $this->Form->create($emailResponse) ?>
<fieldset>
    <?php
        $args = [
            'CHANGE',
            $emailResponse->getSource(),
            null,
            null,
        ];

        $args[4] = $emailResponse::FIELD_ID;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($emailResponse::FIELD_ID) : '';

        $args[4] = $emailResponse::FIELD_EMAIL_SEND_ID;
        /** @var array $emailSends The Email Send Id List */
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($emailResponse::FIELD_EMAIL_SEND_ID, ['options' => $emailSends]) : '';

        $args[4] = $emailResponse::FIELD_EMAIL_RESPONSE_TYPE_ID;
        /** @var array $emailResponseTypes The Email Response Type Id List */
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($emailResponse::FIELD_EMAIL_RESPONSE_TYPE_ID, ['options' => $emailResponseTypes]) : '';

        $args[4] = $emailResponse::FIELD_RECEIVED;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($emailResponse::FIELD_RECEIVED) : '';

        $args[4] = $emailResponse::FIELD_LINK_CLICKED;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($emailResponse::FIELD_LINK_CLICKED) : '';

        $args[4] = $emailResponse::FIELD_IP_ADDRESS;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($emailResponse::FIELD_IP_ADDRESS) : '';

        $args[4] = $emailResponse::FIELD_BOUNCE_REASON;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($emailResponse::FIELD_BOUNCE_REASON) : '';

        $args[4] = $emailResponse::FIELD_MESSAGE_SIZE;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($emailResponse::FIELD_MESSAGE_SIZE) : '';

        ?>
</fieldset>

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Notification $notification
 */

$this->extend('../Layout/CRUD/add');

$this->assign('entity', 'Notifications');
?>
<?= $this->Form->create($notification) ?>
<fieldset>
    <?php
        $args = [
            'CHANGE',
            $notification->getSource(),
            null,
            null,
        ];

        $args[4] = $notification::FIELD_ID;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($notification::FIELD_ID) : '';

        $args[4] = $notification::FIELD_USER_ID;
        /** @var array $users The User Id List */
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($notification::FIELD_USER_ID, ['options' => $users, 'empty' => true]) : '';

        $args[4] = $notification::FIELD_NOTIFICATION_TYPE_ID;
        /** @var array $notificationTypes The Notification Type Id List */
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($notification::FIELD_NOTIFICATION_TYPE_ID, ['options' => $notificationTypes, 'empty' => true]) : '';

        $args[4] = $notification::FIELD_NEW;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($notification::FIELD_NEW) : '';

        $args[4] = $notification::FIELD_NOTIFICATION_HEADER;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($notification::FIELD_NOTIFICATION_HEADER) : '';

        $args[4] = $notification::FIELD_TEXT;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($notification::FIELD_TEXT) : '';

        $args[4] = $notification::FIELD_READ_DATE;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($notification::FIELD_READ_DATE) : '';

        $args[4] = $notification::FIELD_NOTIFICATION_SOURCE;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($notification::FIELD_NOTIFICATION_SOURCE) : '';

        $args[4] = $notification::FIELD_LINK_ID;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($notification::FIELD_LINK_ID) : '';

        $args[4] = $notification::FIELD_LINK_CONTROLLER;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($notification::FIELD_LINK_CONTROLLER) : '';

        $args[4] = $notification::FIELD_LINK_PREFIX;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($notification::FIELD_LINK_PREFIX) : '';

        $args[4] = $notification::FIELD_LINK_ACTION;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($notification::FIELD_LINK_ACTION) : '';

    ?>
</fieldset>
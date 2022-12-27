<?php
/**
 * @var AppView $this
 * @var NotificationType $notificationType
 */

use App\Model\Entity\NotificationType;
use App\View\AppView;

$this->extend('../layout/CRUD/edit');

$this->assign('entity', 'NotificationTypes');
?>
<?= $this->Form->create($notificationType) ?>
<fieldset>
    <?php
        $args = [
            'CHANGE',
            $notificationType->getSource(),
            null,
            null,
        ];

        $args[4] = $notificationType::FIELD_ID;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($notificationType::FIELD_ID) : '';

        $args[4] = $notificationType::FIELD_NOTIFICATION_TYPE;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($notificationType::FIELD_NOTIFICATION_TYPE) : '';

        $args[4] = $notificationType::FIELD_NOTIFICATION_DESCRIPTION;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($notificationType::FIELD_NOTIFICATION_DESCRIPTION) : '';

        $args[4] = $notificationType::FIELD_ICON;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($notificationType::FIELD_ICON) : '';

        $args[4] = $notificationType::FIELD_TYPE_CODE;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($notificationType::FIELD_TYPE_CODE) : '';

        ?>
</fieldset>

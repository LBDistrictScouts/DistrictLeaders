<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Notification $notification
 * @var \App\View\Cell\InformationCell $cell
 */
?>
<?php if ($this->Identity->checkCapability('ALL')) : ?>
    <div class="col">
        <div class="btn-group" role="group" aria-label="Queue Toolbar">
            <?= $this->Form->postLink(
                'Send Email for Notification',
                ['controller' => 'EmailSends', 'action' => 'make', $notification->id],
                [
                    'confirm' => __d('queue', 'Are you sure you want send an email for this #{0}?', $notification->id),
                    'role' => 'button',
                    'class' => 'btn btn-outline-danger',
                ]
            ) ?>
        </div>
    </div>
<?php endif; ?>
<?= $cell ?>
<div class="notifications view large-9 medium-8 columns content">
    <h3><?= h($notification->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $notification->has('user') ? $this->Html->link($notification->user->full_name, ['controller' => 'Users', 'action' => 'view', $notification->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Notification Type') ?></th>
            <td><?= $notification->has('notification_type') ? $this->Html->link($notification->notification_type->id, ['controller' => 'NotificationTypes', 'action' => 'view', $notification->notification_type->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Notification Header') ?></th>
            <td><?= h($notification->notification_header) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Text') ?></th>
            <td><?= h($notification->text) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Notification Source') ?></th>
            <td><?= h($notification->notification_source) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Link Controller') ?></th>
            <td><?= h($notification->link_controller) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Link Prefix') ?></th>
            <td><?= h($notification->link_prefix) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Link Action') ?></th>
            <td><?= h($notification->link_action) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($notification->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Link Id') ?></th>
            <td><?= $this->Number->format($notification->link_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($notification->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Read Date') ?></th>
            <td><?= h($notification->read_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Deleted') ?></th>
            <td><?= h($notification->deleted) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('New') ?></th>
            <td><?= $notification->new ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Email Sends') ?></h4>
        <?php if (!empty($notification->email_sends)) : ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Email Generation Code') ?></th>
                <th scope="col"><?= __('Email Template') ?></th>
                <th scope="col"><?= __('Include Token') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Deleted') ?></th>
                <th scope="col"><?= __('Sent') ?></th>
                <th scope="col"><?= __('Message Send Code') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Subject') ?></th>
                <th scope="col"><?= __('Routing Domain') ?></th>
                <th scope="col"><?= __('From Address') ?></th>
                <th scope="col"><?= __('Friendly From') ?></th>
                <th scope="col"><?= __('Notification Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($notification->email_sends as $emailSends) : ?>
            <tr>
                <td><?= h($emailSends->id) ?></td>
                <td><?= h($emailSends->email_generation_code) ?></td>
                <td><?= h($emailSends->email_template) ?></td>
                <td><?= h($emailSends->include_token) ?></td>
                <td><?= h($emailSends->created) ?></td>
                <td><?= h($emailSends->modified) ?></td>
                <td><?= h($emailSends->deleted) ?></td>
                <td><?= h($emailSends->sent) ?></td>
                <td><?= h($emailSends->message_send_code) ?></td>
                <td><?= h($emailSends->user_id) ?></td>
                <td><?= h($emailSends->subject) ?></td>
                <td><?= h($emailSends->routing_domain) ?></td>
                <td><?= h($emailSends->from_address) ?></td>
                <td><?= h($emailSends->friendly_from) ?></td>
                <td><?= h($emailSends->notification_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'EmailSends', 'action' => 'view', $emailSends->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'EmailSends', 'action' => 'edit', $emailSends->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'EmailSends', 'action' => 'delete', $emailSends->id], ['confirm' => __('Are you sure you want to delete # {0}?', $emailSends->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>

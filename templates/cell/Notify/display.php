<?php
/**
 * @var \App\View\AppView $this
 * @var int $loggedInUserId
 * @var \App\Model\Entity\Notification[] $notifications
 */
?>
<!-- Modal -->
<?php if (isset($loggedInUserId) && is_integer($loggedInUserId)) : ?>
<div class="modal fade" id="notify" tabindex="5" role="dialog" aria-labelledby="userNotifications" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userNotifications">User Notifications</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                        <?php foreach ($notifications as $notification) : ?>
                            <tr>
                                <td><i class="fal <?= h($notification->notification_type->icon) ?>"></i></td>
                                <td><?= h($notification->notification_header) ?></td>
                                <td><?= $this->Time->format($notification->created, 'dd-MMM-yy HH:mm') ?></td>
                                <td class="actions">
                                    <?= $this->Identity->buildAndCheckCapability('VIEW', 'Users') ? $this->Html->link('<i class="fal fa-eye"></i>', ['controller' => 'Notifications', 'action' => 'view', $notification->id], ['title' => __('View Notification'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>


<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Notification $notification
 * @var \App\View\Cell\InformationCell $cell
 */
?>
<?php if ($this->Identity->checkCapability('ALL')) : ?>
    <div class="col">
        <div class="btn-group" role="group" aria-label="Admin Toolbar">
            <?= $this->Form->postLink(
                'Delete Notification',
                ['controller' => 'Notifications', 'action' => 'delete', $notification->id],
                [
                    'confirm' => __d('queue', 'Are you sure you want to delete this notification for {0}?', $notification->user->full_name),
                    'role' => 'button',
                    'class' => 'btn btn-outline-danger',
                ]
            ) ?>
            <?= $this->Form->postLink(
                'Send Email for Notification',
                ['controller' => 'EmailSends', 'action' => 'make', $notification->id],
                [
                    'confirm' => 'Are you sure you want send another email for this notification?',
                    'role' => 'button',
                    'class' => 'btn btn-outline-danger',
                ]
            ) ?>
        </div>
    </div>
<?php endif; ?>
<?= $cell ?>
<?php if ($this->Identity->buildAndCheckCapability('VIEW', 'EmailSends')) : ?>
    <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
        <div class="card-header">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <?php if ($this->Identity->buildAndCheckCapability('VIEW', 'EmailSends')) : ?>
                    <li class="nav-item"><a class="nav-link active" id="sends-tab" data-toggle="tab" href="#sends" role="tab" aria-controls="sends" aria-selected="false" style="font-family: 'Nunito Sans', sans-serif;">Email Responses</a></li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="myTabContent">
                <?php if ($this->Identity->buildAndCheckCapability('VIEW', 'EmailSends')) : ?>
                    <div class="tab-pane fade show active" id="sends" role="tabpanel" aria-labelledby="response-tab">
                        <?php if (!empty($notification->email_sends)) : ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <tr>
                                        <th scope="col">Email Generation Code</th>
                                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                                        <th scope="col">Template</th>
                                        <th scope="col">Date Created</th>
                                        <th scope="col">Sent</th>
                                        <th scope="col">Token</th>
                                    </tr>
                                    <?php foreach ($notification->email_sends as $emailSend) : ?>
                                        <tr>
                                            <td><?= h($emailSend->email_generation_code) ?></td>
                                            <td class="actions">
                                                <?= $this->Identity->buildAndCheckCapability('VIEW', 'EmailSends') ? $this->Html->link('<i class="fal fa-envelope"></i>', ['action' => 'view', $emailSend->id], ['title' => __('View Email Send'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                                <?= $this->Identity->buildAndCheckCapability('DELETE', 'EmailSends') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $emailSend->id], ['confirm' => __('Are you sure you want to delete # {0}?', $emailSend->id), 'title' => __('Delete Email Send'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                            </td>
                                            <td><?= $this->Inflection->space($emailSend->email_template) ?></td>
                                            <td><?= $this->Time->format($emailSend->created, 'dd-MMM-yy HH:mm') ?></td>
                                            <td><?= $this->Icon->iconBoolean($emailSend->has('message_send_code')) ?></td>
                                            <td><?= $this->Icon->iconBoolean($emailSend->include_token) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                        <?php else : ?>
                            <div class="alert alert-dark">No Responses Recorded</div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

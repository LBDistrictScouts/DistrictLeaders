<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmailSend $emailSend
 */
?>
<div class="row">
    <div class="col">
        <?= $this->element('image-header') ?>
        <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
            <div class="card-body">
                <div class="row">
                    <div class="col" style="margin-top: 10px;margin-bottom: 10px;">
                        <h4 style="font-family: 'Nunito Sans', sans-serif;"><?= h($emailSend->subject) ?></h4>
                        <h6 class="text-muted mb-2" style="font-family: 'Nunito Sans', sans-serif;"></h6>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-3 d-lg-flex d-xl-flex justify-content-lg-end justify-content-xl-end" style="margin-top: 10px;margin-bottom: 15px;">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle d-sm-block d-md-block" data-toggle="dropdown" aria-expanded="false" type="button">Actions</button>
                            <div class="dropdown-menu float-left" role="menu">
                                <?= $emailSend->has($emailSend::FIELD_MESSAGE_SEND_CODE) ? '' : $this->Form->postLink('Send Email', ['controller' => 'EmailSends', 'action' => 'send', $emailSend->id], ['confirm' => __d('queue', 'Are you sure you want to send email # {0}?', $emailSend->id), 'role' => 'button', 'class' => 'btn btn-outline-danger']) ?>
                                <?= $this->Identity->buildAndCheckCapability('VIEW', 'Notifications') ? $this->Html->link('<i class="fal fa-bell"></i> View Notification', ['controller' => 'Notifications', 'action' => 'view', $emailSend->notification->id], ['title' => __('View Notification'), 'class' => 'dropdown-item', 'role' => 'presentation', 'escape' => false]) : '' ?>
                                <?= $this->Identity->buildAndCheckCapability('DELETE', 'EmailSends') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i> Delete Email Send', ['controller' => 'EmailSends', 'action' => 'delete', $emailSend->id], ['confirm' => __('Are you sure you want to delete email send ID # {0}?', $emailSend->id), 'title' => __('Delete Section'), 'class' => 'dropdown-item', 'role' => 'presentation', 'escape' => false]) : '' ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="card thick-card">
                            <div class="card-body">
                                <div class="table-borderless">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td><span class="text-muted mb-2">Email Template</span></td>
                                                <td><?= $this->Inflection->space($emailSend->email_template) ?></td>
                                            </tr>
                                            <tr>
                                                <td><span class="text-muted mb-2">Email Generation Code</span></td>
                                                <td><?= h($emailSend->email_generation_code) ?></td>
                                            </tr>
                                            <tr>
                                                <td><span class="text-muted mb-2">Token Included</span></td>
                                                <td><?= $this->Icon->iconBoolean($emailSend->include_token) ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="card thick-card">
                            <div class="card-body">
                                <div class="table-borderless">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td><span class="text-muted mb-2">Message Sent</span></td>
                                                <td><?= $this->Icon->iconBoolean($emailSend->has($emailSend::FIELD_MESSAGE_SEND_CODE)) ?></td>
                                            </tr>
                                            <tr>
                                                <td><span class="text-muted mb-2">Message Send Code</span></td>
                                                <td><?= h($emailSend->message_send_code) ?></td>
                                            </tr>
                                            <?php if (!empty($emailSend->sent)) : ?>
                                                <tr>
                                                    <td><span class="text-muted mb-2">Date Sent</span></td>
                                                    <td><?= $this->Time->format($emailSend->sent, 'dd-MMM-yy HH:mm') ?></td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="card thick-card">
                            <div class="card-body">
                                <div class="table-borderless">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td><span class="text-muted mb-2">Date Created</span></td>
                                            <td><?= $this->Time->format($emailSend->created, 'dd-MMM-yy HH:mm') ?></td>
                                        </tr>
                                        <tr>
                                            <td><span class="text-muted mb-2">Date Modified</span></td>
                                            <td><?= $this->Time->format($emailSend->modified, 'dd-MMM-yy HH:mm') ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="card thick-card">
                            <div class="card-body">
                                <div class="table-borderless">
                                    <table class="table">
                                        <tbody>
                                        <?php if ($emailSend->has($emailSend::FIELD_NOTIFICATION)) : ?>
                                            <tr>
                                                <td><span class="text-muted mb-2">Notification</span></td>
                                                <td><?= $this->Identity->buildAndCheckCapability('VIEW', 'Notifications') ? $this->Html->link($emailSend->notification->notification_header, ['controller' => 'Notifications', 'action' => 'view', $emailSend->notification->id]) : h($emailSend->notification->notification_header) ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        <?php if ($emailSend->has($emailSend::FIELD_USER)) : ?>
                                            <tr>
                                                <td><span class="text-muted mb-2">User</span></td>
                                                <td><?= $this->Identity->buildAndCheckCapability('VIEW', 'Users') ? $this->Html->link($emailSend->user->full_name, ['controller' => 'Users', 'action' => 'view', $emailSend->user->id]) :  $emailSend->user->full_name ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($this->Identity->buildAndCheckCapability('VIEW', 'Tokens') || $this->Identity->buildAndCheckCapability('VIEW', 'EmailResponses')) : ?>
            <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
                <div class="card-header">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <?php if ($this->Identity->buildAndCheckCapability('VIEW', 'Tokens')) : ?>
                            <li class="nav-item"><a class="nav-link active" id="tokens-tab" data-toggle="tab" href="#tokens" role="tab" aria-controls="tokens" aria-selected="true" style="font-family: 'Nunito Sans', sans-serif;">Tokens</a></li>
                        <?php endif; ?>
                        <?php if ($this->Identity->buildAndCheckCapability('VIEW', 'EmailResponses')) : ?>
                            <li class="nav-item"><a class="nav-link" id="response-tab" data-toggle="tab" href="#responses" role="tab" aria-controls="audit" aria-selected="false" style="font-family: 'Nunito Sans', sans-serif;">Email Responses</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        <?php if ($this->Identity->buildAndCheckCapability('VIEW', 'Tokens')) : ?>
                            <div class="tab-pane fade show active" id="tokens" role="tabpanel" aria-labelledby="tokens-tab">
                                <?php foreach ($emailSend->tokens as $token) : ?>
                                    <?php $header = $token->token_header; ?>
                                    <div class="row">
                                        <div class="col" style="margin-top: 10px;margin-bottom: 10px;">
                                            <h4 style="font-family: 'Nunito Sans', sans-serif;">Token #<?= $this->Number->format($token->id) ?></h4>
                                            <h6 class="text-muted mb-2" style="font-family: 'Nunito Sans', sans-serif;"></h6>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-4 col-xl-3 d-lg-flex d-xl-flex justify-content-lg-end justify-content-xl-end" style="margin-top: 10px;margin-bottom: 15px;">
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle d-sm-block d-md-block" data-toggle="dropdown" aria-expanded="false" type="button">Actions</button>
                                                <div class="dropdown-menu float-left" role="menu">
                                                    <?= $this->Identity->buildAndCheckCapability('UPDATE', 'Tokens') ? $this->Form->postLink('<i class="fal fa-lock"></i> Inactivate Token', ['controller' => 'Tokens', 'action' => 'inactivate', $token->id], ['confirm' => __('Are you sure you want to inactivate this token # {0}?', $token->id), 'title' => __('Inactivate Section'), 'class' => 'dropdown-item', 'role' => 'presentation', 'escape' => false]) : '' ?>
                                                    <?= $this->Identity->buildAndCheckCapability('UPDATE', 'Tokens') ? $this->Form->postLink('<i class="fal fa-sync"></i> Parse Token Expiry', ['controller' => 'Tokens', 'action' => 'parse', $token->id], ['confirm' => __('Are you sure you want to parse this token #{0} for expiry / deletion?', $token->id), 'title' => __('Inactivate Section'), 'class' => 'dropdown-item', 'role' => 'presentation', 'escape' => false]) : '' ?>
                                                    <?= $this->Identity->buildAndCheckCapability('DELETE', 'Tokens') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i> Delete Token', ['controller' => 'Tokens', 'action' => 'delete', $token->id], ['confirm' => __('Are you sure you want to delete this token # {0}?', $token->id), 'title' => __('Delete Section'), 'class' => 'dropdown-item', 'role' => 'presentation', 'escape' => false]) : '' ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div class="card thick-card">
                                                <div class="card-body">
                                                    <div class="table-borderless">
                                                        <table class="table">
                                                            <tbody>
                                                                <tr>
                                                                    <td><span class="text-muted mb-2">Active</span></td>
                                                                    <td><?= $this->Icon->iconBoolean($token->active) ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><span class="text-muted mb-2">Authenticates</span></td>
                                                                    <?php $authenticate = ( key_exists('authenticate', $header) && $header['authenticate'] ) ?>
                                                                    <td><?= $this->Icon->iconBoolean($authenticate) ?></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if (key_exists('redirect', $header)) : ?>
                                            <?php $redirect = $header['redirect']; ?>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="card thick-card">
                                                <div class="card-body">
                                                    <div class="table-borderless">
                                                        <table class="table">
                                                            <tbody>
                                                            <?php if (key_exists('controller', $redirect)) : ?>
                                                                <tr>
                                                                    <td><span class="text-muted mb-2">Link Controller</span></td>
                                                                    <td><?= $this->Inflection->space($redirect['controller']) ?></td>
                                                                </tr>
                                                            <?php endif; ?>
                                                            <?php if (key_exists('action', $redirect)) : ?>
                                                                <tr>
                                                                    <td><span class="text-muted mb-2">Link Action</span></td>
                                                                    <td><?= $this->Inflection->space($redirect['action']) ?></td>
                                                                </tr>
                                                            <?php endif; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div class="card thick-card">
                                                <div class="card-body">
                                                    <div class="table-borderless">
                                                        <table class="table">
                                                            <tbody>
                                                            <tr>
                                                                <td><span class="text-muted mb-2">Date Utilised</span></td>
                                                                <td><?= $this->Time->format($token->utilised, 'dd-MMM-yy HH:mm') ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><span class="text-muted mb-2"><?= $token->expires->isFuture() ? 'Date Expires' : 'Date Expired' ?></span></td>
                                                                <td><?= $this->Time->format($token->expires, 'dd-MMM-yy HH:mm') ?></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="card thick-card">
                                                <div class="card-body">
                                                    <div class="table-borderless">
                                                        <table class="table">
                                                            <tbody>
                                                            <tr>
                                                                <td><span class="text-muted mb-2">Date Created</span></td>
                                                                <td><?= $this->Time->format($token->created, 'dd-MMM-yy HH:mm') ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><span class="text-muted mb-2">Date Modified</span></td>
                                                                <td><?= $this->Time->format($token->modified, 'dd-MMM-yy HH:mm') ?></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($this->Identity->buildAndCheckCapability('VIEW', 'EmailResponses')) : ?>
                            <div class="tab-pane fade" id="responses" role="tabpanel" aria-labelledby="response-tab">
                                <?php if (!empty($emailSend->email_responses)) : ?>
                                    <table cellpadding="0" cellspacing="0">
                                        <tr>
                                            <th scope="col"><?= __('Id') ?></th>
                                            <th scope="col"><?= __('Email Send Id') ?></th>
                                            <th scope="col"><?= __('Deleted') ?></th>
                                            <th scope="col"><?= __('Email Response Type Id') ?></th>
                                            <th scope="col"><?= __('Created') ?></th>
                                            <th scope="col"><?= __('Received') ?></th>
                                            <th scope="col"><?= __('Link Clicked') ?></th>
                                            <th scope="col"><?= __('Ip Address') ?></th>
                                            <th scope="col"><?= __('Bounce Reason') ?></th>
                                            <th scope="col"><?= __('Message Size') ?></th>
                                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                                        </tr>
                                        <?php foreach ($emailSend->email_responses as $emailResponses) : ?>
                                            <tr>
                                                <td><?= h($emailResponses->id) ?></td>
                                                <td><?= h($emailResponses->email_send_id) ?></td>
                                                <td><?= h($emailResponses->deleted) ?></td>
                                                <td><?= h($emailResponses->email_response_type_id) ?></td>
                                                <td><?= h($emailResponses->created) ?></td>
                                                <td><?= h($emailResponses->received) ?></td>
                                                <td><?= h($emailResponses->link_clicked) ?></td>
                                                <td><?= h($emailResponses->ip_address) ?></td>
                                                <td><?= h($emailResponses->bounce_reason) ?></td>
                                                <td><?= h($emailResponses->message_size) ?></td>
                                                <td class="actions">
                                                    <?= $this->Html->link(__('View'), ['controller' => 'EmailResponses', 'action' => 'view', $emailResponses->id]) ?>
                                                    <?= $this->Html->link(__('Edit'), ['controller' => 'EmailResponses', 'action' => 'edit', $emailResponses->id]) ?>
                                                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'EmailResponses', 'action' => 'delete', $emailResponses->id], ['confirm' => __('Are you sure you want to delete # {0}?', $emailResponses->id)]) ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                <?php else : ?>
                                    <div class="alert alert-dark">No Responses Recorded</div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

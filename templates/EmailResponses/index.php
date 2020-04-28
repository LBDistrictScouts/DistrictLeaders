<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmailResponse[]|\Cake\Collection\CollectionInterface $emailResponses
 */

$this->extend('../layout/CRUD/index');

$this->assign('entity', 'EmailResponses');
$this->assign('subset', 'All');
$this->assign('add', $this->Identity->checkCapability('CREATE_EMAIL_RESPONSE'));

?>
<thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
        <th scope="col"><?= $this->Paginator->sort('email_send_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('email_response_type_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('created') ?></th>
        <th scope="col"><?= $this->Paginator->sort('received') ?></th>
        <th scope="col"><?= $this->Paginator->sort('link_clicked') ?></th>
        <th scope="col"><?= $this->Paginator->sort('ip_address') ?></th>
        <th scope="col"><?= $this->Paginator->sort('bounce_reason') ?></th>
        <th scope="col"><?= $this->Paginator->sort('message_size') ?></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($emailResponses as $emailResponse) : ?>
    <tr>
        <td><?= h($emailResponse->id) ?></td>
                <td class="actions">
            <?= $this->Identity->checkCapability('VIEW_EMAIL_RESPONSE') ? $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $emailResponse->id], ['title' => __('View Email Response'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('UPDATE_EMAIL_RESPONSE') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $emailResponse->id], ['title' => __('Edit Email Response'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('DELETE_EMAIL_RESPONSE') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $emailResponse->id], ['confirm' => __('Are you sure you want to delete # {0}?', $emailResponse->id), 'title' => __('Delete Email Response'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
        </td>
        <td><?= $this->Number->format($emailResponse->email_send_id) ?></td>
        <td><?= $this->Number->format($emailResponse->email_response_type_id) ?></td>
        <td><?= h($emailResponse->created) ?></td>
        <td><?= h($emailResponse->received) ?></td>
        <td><?= h($emailResponse->link_clicked) ?></td>
        <td><?= h($emailResponse->ip_address) ?></td>
        <td><?= h($emailResponse->bounce_reason) ?></td>
        <td><?= $this->Number->format($emailResponse->message_size) ?></td>
    </tr>
    <?php endforeach; ?>
</tbody>

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmailResponseType[]|\Cake\Collection\CollectionInterface $emailResponseTypes
 */

$this->extend('../Layout/CRUD/index');

$this->assign('entity', 'EmailResponseTypes');
$this->assign('subset', 'All');
$this->assign('add', $this->Identity->checkCapability('CREATE_EMAIL_RESPONSE_TYPE'));

?>
<thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
        <th scope="col"><?= $this->Paginator->sort('email_response_type') ?></th>
        <th scope="col"><?= $this->Paginator->sort('bounce') ?></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($emailResponseTypes as $emailResponseType): ?>
    <tr>
        <td><?= h($emailResponseType->id) ?></td>
                <td class="actions">
            <?= $this->Identity->checkCapability('VIEW_EMAIL_RESPONSE_TYPE') ? $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $emailResponseType->id], ['title' => __('View Email Response Type'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('UPDATE_EMAIL_RESPONSE_TYPE') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $emailResponseType->id], ['title' => __('Edit Email Response Type'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('DELETE_EMAIL_RESPONSE_TYPE') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $emailResponseType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $emailResponseType->id), 'title' => __('Delete Email Response Type'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
        </td>
        <td><?= h($emailResponseType->email_response_type) ?></td>
        <td><?= h($emailResponseType->bounce) ?></td>
    </tr>
    <?php endforeach; ?>
</tbody>
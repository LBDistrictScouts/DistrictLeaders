<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UserContact[]|\Cake\Collection\CollectionInterface $userContacts
 */

$this->extend('../layout/CRUD/index');

$this->assign('entity', 'UserContacts');
$this->assign('subset', 'All');
$this->assign('add', $this->Identity->checkCapability('CREATE_USER_CONTACT'));

?>
<thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('contact_field') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
        <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('user_contact_type_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('created') ?></th>
        <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
        <th scope="col"><?= $this->Paginator->sort('verified') ?></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($userContacts as $userContact) : ?>
    <tr>
        <td><?= h($userContact->contact_field) ?></td>
        <td class="actions">
            <?= $this->Identity->checkCapability('VIEW_USER_CONTACT') ? $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $userContact->id], ['title' => __('View User Contact'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('UPDATE_USER_CONTACT') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $userContact->id], ['title' => __('Edit User Contact'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('DELETE_USER_CONTACT') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $userContact->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userContact->id), 'title' => __('Delete User Contact'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
        </td>
        <td><?= $this->Number->format($userContact->user_id) ?></td>
        <td><?= $this->Number->format($userContact->user_contact_type_id) ?></td>
        <td><?= h($userContact->created) ?></td>
        <td><?= h($userContact->modified) ?></td>
        <td><?= h($userContact->verified) ?></td>
    </tr>
    <?php endforeach; ?>
</tbody>

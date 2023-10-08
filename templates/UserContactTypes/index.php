<?php
/**
 * @var AppView $this
 * @var UserContactType[]|CollectionInterface $userContactTypes
 */

use App\Model\Entity\UserContactType;
use App\View\AppView;
use Cake\Collection\CollectionInterface;

$this->extend('../layout/CRUD/index');

$this->assign('entity', 'UserContactTypes');
$this->assign('subset', 'All');
$this->assign('add', $this->Identity->checkCapability('CREATE_USER_CONTACT_TYPE'));

?>
<thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('user_contact_type') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
        <th scope="col"><?= $this->Paginator->sort('created') ?></th>
        <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($userContactTypes as $userContactType) : ?>
    <tr>
        <td><?= h($userContactType->user_contact_type) ?></td>
                <td class="actions">
            <?= $this->Identity->checkCapability('VIEW_USER_CONTACT_TYPE') ? $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $userContactType->id], ['title' => __('View User Contact Type'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('UPDATE_USER_CONTACT_TYPE') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $userContactType->id], ['title' => __('Edit User Contact Type'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('DELETE_USER_CONTACT_TYPE') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $userContactType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userContactType->id), 'title' => __('Delete User Contact Type'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
        </td>
        <td><?= h($userContactType->created) ?></td>
        <td><?= h($userContactType->modified) ?></td>
    </tr>
    <?php endforeach; ?>
</tbody>

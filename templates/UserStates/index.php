<?php
/**
 * @var AppView $this
 * @var UserState[]|CollectionInterface $userStates
 */

use App\Model\Entity\UserState;
use App\View\AppView;
use Cake\Collection\CollectionInterface;

$this->extend('../layout/CRUD/index');

$this->assign('entity', 'UserStates');
$this->assign('subset', 'All');
$this->assign('add', $this->Identity->checkCapability('CREATE_USER_STATE'));

?>
<thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
        <th scope="col"><?= $this->Paginator->sort('user_state') ?></th>
        <th scope="col"><?= $this->Paginator->sort('active') ?></th>
        <th scope="col"><?= $this->Paginator->sort('expired') ?></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($userStates as $userState) : ?>
    <tr>
        <td><?= h($userState->id) ?></td>
                <td class="actions">
            <?= $this->Identity->checkCapability('VIEW_USER_STATE') ? $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $userState->id], ['title' => __('View User State'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('UPDATE_USER_STATE') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $userState->id], ['title' => __('Edit User State'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('DELETE_USER_STATE') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $userState->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userState->id), 'title' => __('Delete User State'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
        </td>
        <td><?= h($userState->user_state) ?></td>
        <td><?= $this->Icon->iconCheck($userState->active) ?></td>
        <td><?= $this->Icon->iconCheck($userState->expired) ?></td>
    </tr>
    <?php endforeach; ?>
</tbody>

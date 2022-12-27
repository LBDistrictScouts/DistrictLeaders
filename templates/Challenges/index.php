<?php
/**
 * @var AppView $this
 * @var User[]|CollectionInterface $users
 */
use App\Model\Entity\User;
use App\View\AppView;
use Cake\Collection\CollectionInterface;

/**
 * @var AppView $this
 * @var User[]|CollectionInterface $users
 * @var User $authUser
 */

$authUser = $this->getRequest()->getAttribute('identity');

$this->extend('../layout/CRUD/index');

$this->assign('entity', 'Users');
$this->assign('subset', 'All');
$this->assign('add', $this->Identity->checkCapability('ADD_USER'))

?>

<thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort(User::FIELD_FULL_NAME) ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
        <th scope="col"><?= $this->Paginator->sort(User::FIELD_MEMBERSHIP_NUMBER) ?></th>
        <th scope="col"><?= $this->Paginator->sort(User::FIELD_CREATED) ?></th>
        <th scope="col"><?= $this->Paginator->sort(User::FIELD_MODIFIED) ?></th>
        <th scope="col"><?= $this->Paginator->sort(User::FIELD_LAST_LOGIN) ?></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($users as $user) : ?>
    <tr>
        <td><?= h($user->full_name) ?></td>
        <td class="actions">
            <?= $this->Identity->checkCapability('DIRECTORY') ? $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $user->id], ['title' => __('View'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $user->id], ['title' => __('Edit'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) ?>
            <?= $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'title' => __('Delete'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) ?>
        </td>
        <td><?= $this->Number->format($user->membership_number, ['pattern' => '#######']) ?></td>
        <td><?= $this->Time->format($user->created, 'dd-MMM-yy HH:mm') ?></td>
        <td><?= $this->Time->format($user->modified, 'dd-MMM-yy HH:mm') ?></td>
        <td><?= $this->Time->format($user->last_login, 'dd-MMM-yy HH:mm') ?></td>

    </tr>
    <?php endforeach; ?>
</tbody>

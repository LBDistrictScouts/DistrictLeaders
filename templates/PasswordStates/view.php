<?php
/**
 * @var AppView $this
 * @var PasswordState $passwordState
 */

use App\Model\Entity\PasswordState;
use App\View\AppView;

?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Password State'), ['action' => 'edit', $passwordState->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Password State'), ['action' => 'delete', $passwordState->id], ['confirm' => __('Are you sure you want to delete # {0}?', $passwordState->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Password States'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Password State'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="passwordStates view large-9 medium-8 columns content">
    <h3><?= h($passwordState->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Password State') ?></th>
            <td><?= h($passwordState->password_state) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($passwordState->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Active') ?></th>
            <td><?= $passwordState->active ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Expired') ?></th>
            <td><?= $passwordState->expired ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Users') ?></h4>
        <?php if (!empty($passwordState->users)) : ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Username') ?></th>
                <th scope="col"><?= __('Membership Number') ?></th>
                <th scope="col"><?= __('First Name') ?></th>
                <th scope="col"><?= __('Last Name') ?></th>
                <th scope="col"><?= __('Email') ?></th>
                <th scope="col"><?= __('Password') ?></th>
                <th scope="col"><?= __('Address Line 1') ?></th>
                <th scope="col"><?= __('Address Line 2') ?></th>
                <th scope="col"><?= __('City') ?></th>
                <th scope="col"><?= __('County') ?></th>
                <th scope="col"><?= __('Postcode') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Last Login') ?></th>
                <th scope="col"><?= __('Deleted') ?></th>
                <th scope="col"><?= __('Last Login Ip') ?></th>
                <th scope="col"><?= __('Password State Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($passwordState->users as $users) : ?>
            <tr>
                <td><?= h($users->id) ?></td>
                <td><?= h($users->username) ?></td>
                <td><?= h($users->membership_number) ?></td>
                <td><?= h($users->first_name) ?></td>
                <td><?= h($users->last_name) ?></td>
                <td><?= h($users->email) ?></td>
                <td><?= h($users->password) ?></td>
                <td><?= h($users->address_line_1) ?></td>
                <td><?= h($users->address_line_2) ?></td>
                <td><?= h($users->city) ?></td>
                <td><?= h($users->county) ?></td>
                <td><?= h($users->postcode) ?></td>
                <td><?= h($users->created) ?></td>
                <td><?= h($users->modified) ?></td>
                <td><?= h($users->last_login) ?></td>
                <td><?= h($users->deleted) ?></td>
                <td><?= h($users->last_login_ip) ?></td>
                <td><?= h($users->password_state_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Users', 'action' => 'view', $users->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Users', 'action' => 'edit', $users->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Users', 'action' => 'delete', $users->id], ['confirm' => __('Are you sure you want to delete # {0}?', $users->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>

<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->id) ?></h3>
    <table class="vertical-table">
        <?php if ($user->has('username')) : ?>
            <tr>
                <th scope="row"><?= __('Username') ?></th>
                <td><?= h($user->username) ?></td>
            </tr>
        <?php endif; ?>
        <?php if ($user->has('first_name')) : ?>
        <tr>
            <th scope="row"><?= __('First Name') ?></th>
            <td><?= h($user->first_name) ?></td>
        </tr>
        <?php endif; ?>
        <?php if ($user->has('last_name')) : ?>
        <tr>
            <th scope="row"><?= __('Last Name') ?></th>
            <td><?= h($user->last_name) ?></td>
        </tr>
        <?php endif; ?>
        <?php if ($user->has('email')) : ?>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($user->email) ?></td>
        </tr>
        <?php endif; ?>
        <?php if ($user->has('address_line_1')) : ?>
        <tr>
            <th scope="row"><?= __('Address Line 1') ?></th>
            <td><?= h($user->address_line_1) ?></td>
        </tr>
        <?php endif; ?>
        <?php if ($user->has('address_line_2')) : ?>
        <tr>
            <th scope="row"><?= __('Address Line 2') ?></th>
            <td><?= h($user->address_line_2) ?></td>
        </tr>
        <?php endif; ?>
        <?php if ($user->has('city')) : ?>
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= h($user->city) ?></td>
        </tr>
        <?php endif; ?>
        <?php if ($user->has('county')) : ?>
        <tr>
            <th scope="row"><?= __('County') ?></th>
            <td><?= h($user->county) ?></td>
        </tr>
        <?php endif; ?>
        <?php if ($user->has('postcode')) : ?>
        <tr>
            <th scope="row"><?= __('Postcode') ?></th>
            <td><?= h($user->postcode) ?></td>
        </tr>
        <?php endif; ?>
        <?php if ($user->has('id')) : ?>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
        <?php endif; ?>
        <?php if ($user->has('membership_number')) : ?>
        <tr>
            <th scope="row"><?= __('Membership Number') ?></th>
            <td><?= $this->Number->format($user->membership_number) ?></td>
        </tr>
        <?php endif; ?>
        <?php if ($user->has('created')) : ?>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($user->created) ?></td>
        </tr>
        <?php endif; ?>
        <?php if ($user->has('modified')) : ?>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($user->modified) ?></td>
        </tr>
        <?php endif; ?>
        <?php if ($user->has('last_login')) : ?>
        <tr>
            <th scope="row"><?= __('Last Login') ?></th>
            <td><?= h($user->last_login) ?></td>
        </tr>
        <?php endif; ?>
    </table>
    <div class="card text-center">
        <div class="card-header">
            <nav class="nav nav-pills flex-column flex-sm-row">
                <?php if (!empty($user->roles)): ?>
                    <a class="flex-sm-fill text-sm-center nav-link" data-toggle="collapse" href="#roles" role="button" aria-expanded="false" aria-controls="roles">
                        User Roles
                    </a>
                <?php endif; ?>
                <?php if (!empty($user->audits)): ?>
                    <a class="flex-sm-fill text-sm-center nav-link" data-toggle="collapse" href="#recordChanges" role="button" aria-expanded="false" aria-controls="recordChanges">
                        Changes to User Record
                    </a>
                <?php endif; ?>
                <?php if (!empty($user->changes)): ?>
                    <a class="flex-sm-fill text-sm-center nav-link" data-toggle="collapse" href="#recentChanges" role="button" aria-expanded="false" aria-controls="recentChanges">
                        Recent Changes made by User
                    </a>
                <?php endif; ?>
            </nav>
        </div>
    </div>
    <br/>
    <div id="related">
        <?php if (!empty($user->roles)): ?>
            <div class="collapse show" id="roles" data-parent="#related">
                <div class="card">
                    <div class="card-header">
                        <h4><?= __('User Roles') ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tr>
                                    <th scope="col"><?= __('Id') ?></th>
                                    <th scope="col"><?= __('Role Type Id') ?></th>
                                    <th scope="col"><?= __('Section Id') ?></th>
                                    <th scope="col"><?= __('User Id') ?></th>
                                    <th scope="col"><?= __('Role Status Id') ?></th>
                                    <th scope="col"><?= __('Created') ?></th>
                                    <th scope="col"><?= __('Modified') ?></th>
                                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                                </tr>
                                <?php foreach ($user->roles as $roles): ?>
                                    <tr>
                                        <td><?= h($roles->id) ?></td>
                                        <td><?= h($roles->role_type_id) ?></td>
                                        <td><?= h($roles->section_id) ?></td>
                                        <td><?= h($roles->user_id) ?></td>
                                        <td><?= h($roles->role_status_id) ?></td>
                                        <td><?= h($roles->created) ?></td>
                                        <td><?= h($roles->modified) ?></td>
                                        <td class="actions">
                                            <?= $this->Html->link(__('View'), ['controller' => 'Roles', 'action' => 'view', $roles->id]) ?>
                                            <?= $this->Html->link(__('Edit'), ['controller' => 'Roles', 'action' => 'edit', $roles->id]) ?>
                                            <?= $this->Form->postLink(__('Delete'), ['controller' => 'Roles', 'action' => 'delete', $roles->id], ['confirm' => __('Are you sure you want to delete # {0}?', $roles->id)]) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if (!empty($user->audits)): ?>
            <div class="collapse" id="recordChanges" data-parent="#related">
                <div class="card">
                    <div class="card-header">
                        <h4><?= __('Record Changes') ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tr>
                                    <th scope="col"><?= __('Audit Field') ?></th>
                                    <th scope="col"><?= __('Old Value') ?></th>
                                    <th scope="col"><?= __('New Value') ?></th>
                                    <th scope="col"><?= __('Changed By') ?></th>
                                    <th scope="col"><?= __('Change Date') ?></th>
                                </tr>
                                <?php foreach ($user->audits as $audit): ?>
                                    <tr>
                                        <td><?= $this->Inflection->space($audit->audit_field) ?></td>
                                        <td><?= h($audit->original_value) ?></td>
                                        <td><?= h($audit->modified_value) ?></td>
                                        <td><?= $audit->has('user') ? $this->Html->link($audit->user->full_name, ['controller' => 'Users', 'action' => 'view', $audit->user->id]) : '' ?></td>
                                        <td><?= $this->Time->i18nformat($audit->change_date,'dd-MMM-yy HH:mm') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if (!empty($user->changes)): ?>
            <div class="collapse" id="recentChanges" data-parent="#related">
                <div class="card">
                    <div class="card-header">
                        <h4><?= __('Recent Changes') ?></h4>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tr>
                                    <th scope="col"><?= __('Changed User') ?></th>
                                    <th scope="col"><?= __('Audit Field') ?></th>
                                    <th scope="col"><?= __('Old Value') ?></th>
                                    <th scope="col"><?= __('New Value') ?></th>
                                    <th scope="col"><?= __('Change Date') ?></th>
                                </tr>
                                <?php foreach ($user->changes as $audit): ?>
                                    <tr>
                                        <td><?= $audit->has('changed_user') ? $this->Html->link($audit->changed_user->full_name, ['controller' => 'Users', 'action' => 'view', $audit->changed_user->id]) : '' ?></td>
                                        <td><?= $this->Inflection->space($audit->audit_field) ?></td>
                                        <td><?= h($audit->original_value) ?></td>
                                        <td><?= h($audit->modified_value) ?></td>
                                        <td><?= $this->Time->i18nformat($audit->change_date,'dd-MMM-yy HH:mm') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

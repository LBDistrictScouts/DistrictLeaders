<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var \App\Model\Entity\Audit $audit
 */

$authUser = $this->getRequest()->getAttribute('identity');

?>
<div class="container">
    <div class="row">
        <div class="col">
            <div class="jumbotron d-none d-sm-none d-md-flex d-lg-flex d-xl-flex" style="background-image: url(/img/activity-bg-2.jpg);background-size: cover;height: 300px;"></div>
            <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
                <div class="card-body">
                    <div class="row">
                        <div class="col" style="margin-top: 10px;margin-bottom: 10px;">
                            <h4>Jacob Tyler</h4>
                            <h6 class="text-muted mb-2">475931</h6>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-4 col-xl-3 d-lg-flex d-xl-flex justify-content-lg-end justify-content-xl-end" style="margin-top: 10px;margin-bottom: 15px;">
                            <div class="dropdown d-lg-none"><button class="btn btn-primary dropdown-toggle d-sm-block d-md-block" data-toggle="dropdown" aria-expanded="false" type="button">Actions&nbsp;</button>
                                <div class="dropdown-menu" role="menu"><a class="dropdown-item" role="presentation" href="#">First Item</a><a class="dropdown-item" role="presentation" href="#">Second Item</a><a class="dropdown-item" role="presentation" href="#">Third Item</a></div>
                            </div>
                            <div class="dropleft d-none d-sm-none d-lg-inline"><button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button">Actions</button>
                                <div class="dropdown-menu dropdown-menu-right" role="menu">
                                    <?= $this->Html->link('Add Email', ['controller' => 'UserContacts', 'action' => 'add', '?' => ['user_contact_type' => 'email', 'user_id' => $user->get($user::FIELD_ID)]], ['class' => 'dropdown-item', 'role' => 'presentation'])  ?>
                                    <a class="dropdown-item" role="presentation" href="#">First Item</a>
                                    <a class="dropdown-item" role="presentation" href="#">Second Item</a>
                                    <a class="dropdown-item" role="presentation" href="#">Third Item</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if (!empty($user->roles)): ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th><?= __('Role Type') ?></th>
                                <th><?= __('Section') ?></th>
                                <th><?= __('Email') ?></th>
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($user->roles as $roles): ?>
                            <tr>
                                <td><?= $roles->has('role_type') ? h($roles->role_type->role_type) : '' ?> <?= $roles->has('role_status') && $roles->role_status->role_status != 'Active' ? '<span class="badge badge-info">' . h($roles->role_status->role_status) . '</span>' : '' ?></td>
                                <td><?= $roles->has('section') ? h($roles->section->section) : '' ?></td>
                                <td><?= $roles->has('user_contact') ? $this->Text->autoLinkEmails($roles->user_contact->contact_field) : '' ?></td>
                                <td class="actions">
                                    <?= $authUser->checkCapability('DIRECTORY') ? $this->Html->link('<i class="fal fa-eye"></i> Group', ['controller' => 'ScoutGroups', 'action' => 'view', $roles->section->scout_group_id], ['title' => __('View'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                    <?= $authUser->checkCapability('DIRECTORY') ? $this->Html->link('<i class="fal fa-eye"></i> Role Type', ['controller' => 'RoleTypes', 'action' => 'view', $roles->role_type_id], ['title' => __('View'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                    <?= $authUser->checkCapability('UPDATE_ROLE') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['controller' => 'Roles', 'action' => 'edit', $roles->id], ['title' => __('Edit'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                    <?= $authUser->checkCapability('DELETE_ROLE') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['controller' => 'Roles', 'action' => 'delete', $roles->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'title' => __('Delete'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-6">
                    <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
                        <div class="card-body">
                            <h5>Address</h5>
                            <p class="card-text"><?= h($user->address_line_1) ?>,<br>Letchworth,<br>Hertfordshire.<br><strong>SG6 1FT</strong></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-6">
                    <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
                        <div class="card-body">
                            <h5>Contact Numbers</h5>
                            <p class="card-text"><i class="fas fa-phone"></i>&nbsp;01462 682165</p>
                            <p class="card-text"><i class="fas fa-phone"></i>&nbsp;07804 918252</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>








<div class="users view large-9 medium-8 columns content">
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Dropdown button
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="#">Something else here</a>
        </div>
    </div>


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
            <td></td>
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
                                        <td><?= $this->Time->format($audit->change_date, 'dd-MMM-yy HH:mm') ?></td>
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
                                        <td><?= $this->Time->format($audit->change_date, 'dd-MMM-yy HH:mm') ?></td>
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

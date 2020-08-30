<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var \App\Model\Entity\Audit $audit
 */

$ownUser = $user->id === $this->Identity->getId();
$editOwn = $this->Identity->checkCapability('OWN_USER') && $ownUser;

?>
<div class="row">
    <div class="col">
        <?= $this->element('image-header') ?>
        <div class="card thick-card"">
            <div class="card-body">
                <div class="row">
                    <div class="col" style="margin-top: 10px;margin-bottom: 10px;">
                        <h4><?= $user->full_name ?></h4>
                        <h6 class="text-muted mb-2"><?= $user->membership_number ?></h6>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-3 d-lg-flex d-xl-flex justify-content-lg-end justify-content-xl-end" style="margin-top: 10px;margin-bottom: 15px;">
                        <div class="dropdown d-lg-none"><button class="btn btn-primary dropdown-toggle d-sm-block d-md-block" data-toggle="dropdown" aria-expanded="false" type="button">Actions&nbsp;</button>
                            <div class="dropdown-menu" role="menu"><a class="dropdown-item" role="presentation" href="#">First Item</a><a class="dropdown-item" role="presentation" href="#">Second Item</a><a class="dropdown-item" role="presentation" href="#">Third Item</a></div>
                        </div>
                        <div class="dropleft d-none d-sm-none d-lg-inline"><button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button">Actions</button>
                            <div class="dropdown-menu dropdown-menu-right" role="menu">
                                <?= $this->Permissions->dropDownButton('Edit User', $user, 'edit') ?>
                                <?= $this->Identity->buildAndCheckCapability('CREATE', 'UserContacts') || $editOwn ? $this->Html->link('Add Contact Email', ['controller' => 'UserContacts', 'action' => 'add', '?' => ['user_contact_type' => 'email', 'user_id' => $user->get($user::FIELD_ID)]], ['class' => 'dropdown-item', 'role' => 'presentation']) : '' ?>
                                <?= $this->Identity->buildAndCheckCapability('CREATE', 'UserContacts') || $editOwn ? $this->Html->link('Add Phone Number', ['controller' => 'UserContacts', 'action' => 'add', '?' => ['user_contact_type' => 'phone', 'user_id' => $user->get($user::FIELD_ID)]], ['class' => 'dropdown-item', 'role' => 'presentation']) : '' ?>
                                <?= $this->Identity->buildAndCheckCapability('CREATE', 'Roles') ? $this->Html->link('Add User Role', ['controller' => 'Roles', 'action' => 'add', '?' => ['user_id' => $user->get($user::FIELD_ID)]], ['class' => 'dropdown-item', 'role' => 'presentation']) : '' ?>
                                <?= $this->Permissions->dropDownButton('View User Capabilities', $user, 'permissions', 'Capabilities') ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if (!empty($user->roles)) : ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col"><?= __('Role Type') ?></th>
                            <th scope="col"><?= __('Section') ?></th>
                            <th scope="col"><?= __('Email') ?></th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($user->roles as $roles) : ?>
                        <tr>
                            <td><?= $roles->has('role_type') ? h($roles->role_type->role_type) : '' ?> <?= $roles->has('role_status') && $roles->role_status->role_status != 'Active' ? '<span class="badge badge-info">' . h($roles->role_status->role_status) . '</span>' : '' ?></td>
                            <td><?= $roles->has('section') ? h($roles->section->section) : '' ?></td>
                            <td><?= $roles->has('user_contact') ? $this->Text->autoLinkEmails($roles->user_contact->contact_field) : '' ?></td>
                            <td class="actions">
                                <?= $this->Identity->checkCapability('DIRECTORY') ? $this->Html->link('<i class="fal fa-eye"></i> Group', ['controller' => 'ScoutGroups', 'action' => 'view', $roles->section->scout_group_id], ['title' => __('View'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                <?= $this->Identity->checkCapability('DIRECTORY') ? $this->Html->link('<i class="fal fa-eye"></i> Role Type', ['controller' => 'RoleTypes', 'action' => 'view', $roles->role_type_id], ['title' => __('View'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                <?= $this->Identity->checkCapability('UPDATE_ROLE') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['controller' => 'Roles', 'action' => 'edit', $roles->id], ['title' => __('Edit'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                <?= $this->Identity->checkCapability('DELETE_ROLE') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['controller' => 'Roles', 'action' => 'delete', $roles->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'title' => __('Delete'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
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
            <?php
            $text = '';

            if (!$user->has($user::FIELD_USER_STATE)) {
                $userStateColour = 'light';
            } elseif ($user->user_state->expired) {
                $userStateColour = 'warning';
            } elseif ($user->user_state->active) {
                $userStateColour = 'success';
            } else {
                $userStateColour = 'dark';
                $text = 'text-white';
            }
            ?>

            <?php if ($user->has($user::FIELD_USER_STATE) || $user->has($user::FIELD_ADDRESS_LINE_1)) : ?>
            <div class="col-sm-12 col-lg-6">
                <?php if ($user->has($user::FIELD_USER_STATE)) : ?>
                    <div class="card bg-<?= $userStateColour ?>" style="margin-top: 15px;margin-bottom: 15px;">
                        <div class="card-header <?= $text ?>"><?= $user->user_state->user_state ?></div>
                    </div>
                <?php endif; ?>
                <?php if ($user->has($user::FIELD_ADDRESS_LINE_1)) : ?>
                <div class="card thick-card">
                    <div class="card-body">
                        <h5>Address</h5>
                        <p class="card-text"><?= h($user->address_line_1) ?>,<br><?= h($user->city) ?>,<br><?= h($user->county) ?>.<br><strong><?= h($user->postcode) ?></strong></p>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <?php
                $canCreateUCs =  $this->Identity->buildAndCheckCapability('CREATE', 'UserContacts') || $editOwn;
                $canMakePrimary = $canCreateUCs || $this->Identity->buildAndCheckCapability('UPDATE', 'Users');
            ?>
            <div class="col-sm-12 col-lg-6">
                <?php if (!empty($user->contact_emails)) : ?>
                    <div class="card thick-card">
                        <div class="card-body">
                            <h5>Email Addresses</h5>
                            <div class="table-responsive table-borderless">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col"><?= __('Primary') ?></th>
                                        <th scope="col"><?= __('Email') ?></th>
                                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($user->contact_emails as $contactEmail) : ?>
                                        <?php $isPrimary = (bool)($contactEmail->contact_field == $user->email); ?>
                                        <tr>
                                            <td><?= $isPrimary ? $this->Icon->iconHtml('check-circle') : $this->Icon->iconHtml('circle') ?></td>
                                            <td><?= $this->Text->autoLinkEmails($contactEmail->contact_field) ?></td>
                                            <td>
                                                <?= $canMakePrimary && !$isPrimary && $contactEmail->validated ? $this->Form->postLink($this->Icon->iconHtml('check-circle'), ['controller' => 'UserContacts', 'action' => 'primary', $contactEmail->id], ['confirm' => __('Are you sure you want to make {0} the primary email for {1}?', $contactEmail->contact_field, $user->full_name), 'title' => __('Make Primary'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                                <?= $contactEmail->has($contactEmail::FIELD_DIRECTORY_USER) && $this->Identity->buildAndCheckCapability('VIEW', 'DirectoryUsers') ? $this->Html->link($this->Icon->iconHtml('book-open'), ['controller' => 'DirectoryUsers', 'action' => 'view', $contactEmail->directory_user_id ], ['title' => 'Directory Record', 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                                <?= ( $this->Identity->buildAndCheckCapability('DELETE', 'UserContacts') || $editOwn ) && $user->all_email_count > 1 ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['controller' => 'UserContacts', 'action' => 'delete', $contactEmail->id], ['confirm' => __('Are you sure you want to delete email {0} for user {1}?', $contactEmail->contact_field, $user->full_name), 'title' => __('Delete User Email'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php if ($canCreateUCs) : ?>
                                <p class="card-text"><?= $this->Html->link($this->Icon->iconHtml('at') . ' Add a Contact Email', ['controller' => 'UserContacts', 'action' => 'add', '?' => ['user_contact_type' => 'email', 'user_id' => $user->id]], ['escape' => false])?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($user->contact_numbers)) : ?>
                    <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
                        <div class="card-body">
                            <h5>Contact Numbers</h5>
                            <?php foreach ($user->contact_numbers as $contactNumber) : ?>
                                <?php if ($contactNumber->user_contact_type->user_contact_type == 'Phone') : ?>
                                    <p class="card-text"><?= $this->Icon->iconHtml('phone') ?> <?= h($contactNumber->contact_field) ?></p>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <?php if ($canCreateUCs) : ?>
                                <p class="card-text"><?= $this->Html->link($this->Icon->iconHtml('phone-plus') . ' Add a Phone Number', ['controller' => 'UserContacts', 'action' => 'add', '?' => ['user_contact_type' => 'phone', 'user_id' => $user->id]], ['escape' => false])?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php if ($this->Identity->checkCapability('HISTORY')) : ?>
<div class="card" style="margin-top: 15px;margin-bottom: 15px;">
    <div class="card-header">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item"><a class="nav-link active" id="changes-tab" data-toggle="tab" href="#changes" role="tab" aria-controls="changes" aria-selected="true" style="font-family: 'Nunito Sans', sans-serif;">Changes Made by User</a></li>
            <li class="nav-item"><a class="nav-link" id="audit-tab" data-toggle="tab" href="#audit" role="tab" aria-controls="audit" aria-selected="false" style="font-family: 'Nunito Sans', sans-serif;">Changes to User</a></li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="changes" role="tabpanel" aria-labelledby="changes-tab">
                <?php if (!empty($user->changes)) : ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tr>
                                <th scope="col"><?= __('Changed Record') ?></th>
                                <th scope="col"><?= __('Actions') ?></th>
                                <th scope="col"><?= __('Audit Field') ?></th>
                                <th scope="col"><?= __('Old Value') ?></th>
                                <th scope="col"><?= __('New Value') ?></th>
                                <th scope="col"><?= __('Change Date') ?></th>
                            </tr>
                            <?php foreach ($user->changes as $audit) : ?>
                                <tr>
                                    <?php if ($audit->has('changed_user')) : ?>
                                        <td><?= h($audit->changed_user->full_name) ?></td>
                                        <td class="actions">
                                            <?= $this->Identity->buildAndCheckCapability('VIEW', 'Users') ? $this->Html->link('<i class="fal fa-eye"></i>', ['controller' => 'Users', 'action' => 'view', $audit->changed_user->id], ['title' => __('View User'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                            <?= $this->Identity->buildAndCheckCapability('UPDATE', 'Users') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['controller' => 'Users', 'action' => 'edit', $audit->changed_user->id], ['title' => __('Edit User'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                            <?= $this->Identity->buildAndCheckCapability('DELETE', 'Users') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['controller' => 'Users', 'action' => 'delete', $audit->changed_user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'title' => __('Delete User'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                        </td>
                                    <?php endif; ?>
                                    <?php if ($audit->has('changed_scout_group')) : ?>
                                        <td><?= h($audit->changed_scout_group->group_alias) ?></td>
                                        <td class="actions">
                                            <?= $this->Identity->buildAndCheckCapability('VIEW', 'ScoutGroups') ? $this->Html->link('<i class="fal fa-eye"></i>', ['controller' => 'ScoutGroups', 'action' => 'view', $audit->changed_scout_group->id], ['title' => __('View Scout Group'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                            <?= $this->Identity->buildAndCheckCapability('UPDATE', 'ScoutGroups') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['controller' => 'ScoutGroups', 'action' => 'edit', $audit->changed_scout_group->id], ['title' => __('Edit Scout Group'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                            <?= $this->Identity->buildAndCheckCapability('DELETE', 'ScoutGroups') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['controller' => 'ScoutGroups', 'action' => 'delete', $audit->changed_scout_group->id], ['confirm' => __('Are you sure you want to delete # {0}?', $audit->changed_scout_group->id), 'title' => __('Delete Scout Group'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                        </td>
                                    <?php endif; ?>
                                    <?php if ($audit->has('changed_role')) : ?>
                                        <td><?= is_null($audit->changed_role->user->full_name) ? 'User' : $this->Text->truncate($audit->changed_role->user->full_name, 20) ?> @ <?= is_null($audit->changed_role->role_type->role_abbreviation) ? 'Role' : $this->Text->truncate($audit->changed_role->role_type->role_abbreviation, 15) ?></td>
                                        <td class="actions">
                                            <?= $this->Identity->buildAndCheckCapability('VIEW', 'Roles') ? $this->Html->link('<i class="fal fa-eye"></i>', ['controller' => 'Roles', 'action' => 'view', $audit->changed_role->id], ['title' => __('View Role'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                            <?= $this->Identity->buildAndCheckCapability('UPDATE', 'Roles') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['controller' => 'Roles', 'action' => 'edit', $audit->changed_role->id], ['title' => __('Edit Role'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                            <?= $this->Identity->buildAndCheckCapability('DELETE', 'Roles') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['controller' => 'Roles', 'action' => 'delete', $audit->changed_role->id], ['confirm' => __('Are you sure you want to delete # {0}?', $audit->changed_role->id), 'title' => __('Delete Role'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                        </td>
                                    <?php endif; ?>
                                    <?php if ($audit->has('changed_user_contact')) : ?>
                                        <td><?= h($audit->changed_user_contact->user->full_name) . ' : ' . h($audit->changed_user_contact->user_contact_type->user_contact_type) ?></td>
                                        <td class="actions">
                                            <?= $this->Identity->buildAndCheckCapability('VIEW', 'Users') ? $this->Html->link('<i class="fal fa-eye"></i>', ['controller' => 'Users', 'action' => 'view', $audit->changed_user_contact->user_id], ['title' => __('View User Contact'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                            <?= $this->Identity->buildAndCheckCapability('UPDATE', 'Users') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['controller' => 'UserContacts', 'action' => 'edit', $audit->changed_user_contact->id], ['title' => __('Edit User Contact'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                            <?= $this->Identity->buildAndCheckCapability('DELETE', 'Users') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['controller' => 'UserContacts', 'action' => 'delete', $audit->changed_user_contact->id], ['confirm' => __('Are you sure you want to delete # {0}?', $audit->changed_user_contact->id), 'title' => __('Delete User Contact'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                        </td>
                                    <?php endif; ?>
                                    <td><?= $this->Inflection->space($audit->audit_field) ?></td>
                                    <td><?= is_null($audit->original_value) ? '' : $this->Text->truncate($audit->original_value, 20) ?></td>
                                    <td><?= is_null($audit->modified_value) ? '' : $this->Text->truncate($audit->modified_value, 20) ?></td>
                                    <td><?= $this->Time->format($audit->change_date, 'dd-MMM-yy') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php else : ?>
                    <p>No Changes</p>
                <?php endif; ?>
            </div>
            <div class="tab-pane fade" id="audit" role="tabpanel" aria-labelledby="audit-tab">
                <?php if (!empty($user->audits)) : ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tr>
                                <th scope="col"><?= __('Audit Field') ?></th>
                                <th scope="col"><?= __('Old Value') ?></th>
                                <th scope="col"><?= __('New Value') ?></th>
                                <th scope="col"><?= __('Changed By') ?></th>
                                <th scope="col"><?= __('Change Date') ?></th>
                            </tr>
                            <?php foreach ($user->audits as $audit) : ?>
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
                <?php else : ?>
                    <p>No Changes</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>


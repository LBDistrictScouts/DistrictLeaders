<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var \App\Model\Entity\Audit $audit
 */

$authUser = $this->getRequest()->getAttribute('identity');

?>
<div class="row">
    <div class="col">
        <div class="jumbotron d-none d-sm-none d-md-flex d-lg-flex d-xl-flex" style="background-image: url(/img/activity-bg-2.jpg);background-size: cover;height: 300px;"></div>
        <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
            <div class="card-body">
                <div class="row">
                    <div class="col" style="margin-top: 10px;margin-bottom: 10px;">
                        <h4><?= $user->full_name ?></h4>
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
                        <p class="card-text"><?= h($user->address_line_1) ?>,<br><?= h($user->city) ?>,<br><?= h($user->county) ?>.<br><strong><?= h($user->postcode) ?></strong></p>
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
                <?php if (!empty($user->changes)): ?>
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
                <?php else: ?>
                    <p>No Changes</p>
                <?php endif; ?>
            </div>
            <div class="tab-pane fade" id="audit" role="tabpanel" aria-labelledby="audit-tab">
                <?php if (!empty($user->audits)): ?>
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
                <?php else: ?>
                    <p>No Changes</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

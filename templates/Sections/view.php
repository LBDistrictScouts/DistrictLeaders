<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Section $section
 */

?>
<div class="row">
    <div class="col">
        <?= $this->element('image-header') ?>
        <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
            <div class="card-body">
                <div class="row">
                    <div class="col" style="margin-top: 10px;margin-bottom: 10px;">
                        <h4 style="font-family: 'Nunito Sans', sans-serif;"><?= h($section->section) ?></h4>
                        <h6 class="text-muted mb-2" style="font-family: 'Nunito Sans', sans-serif;"></h6>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-3 d-lg-flex d-xl-flex justify-content-lg-end justify-content-xl-end" style="margin-top: 10px;margin-bottom: 15px;">
                        <div class="dropdown d-lg-none"><button class="btn btn-primary dropdown-toggle d-sm-block d-md-block" data-toggle="dropdown" aria-expanded="false" type="button">Actions&nbsp;</button>
                            <div class="dropdown-menu" role="menu">
                                <?= $this->Identity->buildAndCheckCapability('VIEW', 'ScoutGroups') ? $this->Html->link('<i class="fal fa-sitemap"></i> View Scout Group', ['controller' => 'ScoutGroups', 'action' => 'view', $section->scout_group->id], ['title' => __('View Section'), 'class' => 'dropdown-item', 'role' => 'presentation', 'escape' => false]) : '' ?>
                                <?= $this->Identity->buildAndCheckCapability('UPDATE', 'Sections') ? $this->Html->link('<i class="fal fa-pencil"></i> Edit Section', ['controller' => 'Sections', 'action' => 'edit', $section->id], ['title' => __('Edit Section'), 'class' => 'dropdown-item', 'role' => 'presentation', 'escape' => false]) : '' ?>
                                <?= $this->Identity->buildAndCheckCapability('DELETE', 'Sections') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i> Delete Section', ['controller' => 'Sections', 'action' => 'delete', $section->id], ['confirm' => __('Are you sure you want to delete # {0}?', $section->id), 'title' => __('Delete Section'), 'class' => 'dropdown-item', 'role' => 'presentation', 'escape' => false]) : '' ?>
                            </div>
                        </div>
                        <div class="dropleft d-none d-sm-none d-lg-inline"><button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button" style="font-family: 'Nunito Sans', sans-serif;">Actions</button>
                            <div class="dropdown-menu dropdown-menu-right" role="menu">
                                <?= $this->Identity->buildAndCheckCapability('VIEW', 'ScoutGroups') ? $this->Html->link('<i class="fal fa-sitemap"></i> View Scout Group', ['controller' => 'ScoutGroups', 'action' => 'view', $section->scout_group->id], ['title' => __('View Section'), 'class' => 'dropdown-item', 'role' => 'presentation', 'escape' => false]) : '' ?>
                                <?= $this->Identity->buildAndCheckCapability('UPDATE', 'Sections') ? $this->Html->link('<i class="fal fa-pencil"></i> Edit Section', ['controller' => 'Sections', 'action' => 'edit', $section->id], ['title' => __('Edit Section'), 'class' => 'dropdown-item', 'role' => 'presentation', 'escape' => false]) : '' ?>
                                <?= $this->Identity->buildAndCheckCapability('DELETE', 'Sections') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i> Delete Section', ['controller' => 'Sections', 'action' => 'delete', $section->id], ['confirm' => __('Are you sure you want to delete # {0}?', $section->id), 'title' => __('Delete Section'), 'class' => 'dropdown-item', 'role' => 'presentation', 'escape' => false]) : '' ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php if (!empty($section->meeting_start_time) || !empty($section->meeting_weekday)) : ?>
                    <div class="col-sm-12 col-md-6">
                        <div class="card thick-card">
                            <div class="card-body">
                                <div class="table-borderless">
                                    <table class="table">
                                        <tbody>
                                        <?php if (!empty($section->meeting_weekday)) : ?>
                                        <tr>
                                            <td><span class="text-muted mb-2">Meeting Day</span></td>
                                            <td><?= h($section->meeting_weekday) ?></td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if (!empty($section->meeting_start_time)) : ?>
                                            <tr>
                                                <td><span class="text-muted mb-2">Start Time</span></td>
                                                <td><?= h($section->meeting_start_time) ?></td>
                                            </tr>
                                            <tr>
                                                <td><span class="text-muted mb-2">End Time</span></td>
                                                <td><?= h($section->meeting_end_time) ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="col-sm-12 col-md-6">
                        <div class="card thick-card">
                            <div class="card-body">
                                <div class="table-borderless">
                                    <table class="table">
                                        <tbody>
                                        <?php if ($section->has($section::FIELD_SCOUT_GROUP)) : ?>
                                        <tr>
                                            <td><span class="text-muted mb-2">Scout Group</span></td>
                                            <td><?= $this->Identity->buildAndCheckCapability('VIEW', 'ScoutGroups') ? $this->Html->link($section->scout_group->scout_group, ['controller' => 'ScoutGroups', 'action' => 'view', $section->scout_group->id]) : h($section->scout_group->scout_group) ?></td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if ($section->has($section::FIELD_SECTION_TYPE)) : ?>
                                        <tr>
                                            <td><span class="text-muted mb-2">Section Type</span></td>
                                            <td><?= $this->Identity->buildAndCheckCapability('VIEW', 'SectionTypes') ? $this->Html->link($section->section_type->section_type, ['controller' => 'SectionTypes', 'action' => 'view', $section->section_type->id]) :  $section->section_type->section_type ?></td>
                                        </tr>
                                        <?php endif; ?>
                                        <tr>
                                            <td><span class="text-muted mb-2">Visible on the Website</span></td>
                                            <td><?= $this->Icon->iconBoolean($section->public) ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($this->Identity->buildAndCheckCapability('VIEW', 'Roles') || $this->Identity->checkCapability('HISTORY') || $this->Identity->checkCapability('DIRECTORY')) : ?>
            <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
                <div class="card-header">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <?php if ($this->Identity->buildAndCheckCapability('VIEW', 'Roles') || $this->Identity->checkCapability('DIRECTORY')) : ?>
                            <li class="nav-item"><a class="nav-link active" id="roles-tab" data-toggle="tab" href="#roles" role="tab" aria-controls="roles" aria-selected="true" style="font-family: 'Nunito Sans', sans-serif;">Leaders</a></li>
                        <?php endif; ?>
                        <?php if ($this->Identity->checkCapability('HISTORY')) : ?>
                            <li class="nav-item"><a class="nav-link" id="audit-tab" data-toggle="tab" href="#audit" role="tab" aria-controls="audit" aria-selected="false" style="font-family: 'Nunito Sans', sans-serif;">Changes to Section</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        <?php if ($this->Identity->buildAndCheckCapability('VIEW', 'Roles') || $this->Identity->checkCapability('DIRECTORY')) : ?>
                            <div class="tab-pane fade show active" id="roles" role="tabpanel" aria-labelledby="roles-tab">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">Leader</th>
                                            <th scope="col">Actions</th>
                                            <th scope="col">Role Type</th>
                                            <th scope="col">Leader Contact</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($section->roles as $role) : ?>
                                            <tr>
                                                <td><?= $role->user->full_name ?></td>
                                                <td class="actions">
                                                    <?= $this->Identity->checkCapability('VIEW_ROLE') ? $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $role->id], ['title' => __('View Role'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                                    <?= $this->Identity->checkCapability('UPDATE_ROLE') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $role->id], ['title' => __('Edit Role'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                                    <?= $this->Identity->checkCapability('DELETE_ROLE') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $role->id], ['confirm' => __('Are you sure you want to delete # {0}?', $role->id), 'title' => __('Delete Role'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                                </td>
                                                <td><?= $role->has($role::FIELD_ROLE_TYPE) ? $role->role_type->role_type : '' ?></td>
                                                <td><?= $role->has('user_contact') ? $this->Text->autoLinkEmails($role->user_contact->contact_field) : $this->Text->autoLinkEmails($role->user->email) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if ($this->Identity->checkCapability('HISTORY')) : ?>
                            <div class="tab-pane fade" id="audit" role="tabpanel" aria-labelledby="audit-tab">
                                <div class="table-borderless">
                                    <table class="table">
                                        <tr>
                                            <td><span class="text-muted mb-2">Date Created</span></td>
                                            <td><?= $this->Time->format($section->created, 'dd-MMM-yy HH:mm') ?></td>
                                        </tr>
                                        <tr>
                                            <td><span class="text-muted mb-2">Date Updated</span></td>
                                            <td><?= $this->Time->format($section->modified, 'dd-MMM-yy HH:mm') ?></td>
                                        </tr>
                                    </table>
                                </div>
                                <?php if (!empty($section->audits)) : ?>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <tr>
                                                <th scope="col"><?= __('Audit Field') ?></th>
                                                <th scope="col"><?= __('Old Value') ?></th>
                                                <th scope="col"><?= __('New Value') ?></th>
                                                <th scope="col"><?= __('Changed By') ?></th>
                                                <th scope="col"><?= __('Change Date') ?></th>
                                            </tr>
                                            <?php foreach ($section->audits as $audit) : ?>
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
                                    <div class="alert alert-dark">No Changes</div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

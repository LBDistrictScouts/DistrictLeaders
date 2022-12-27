<?php
/**
 * @var AppView $this
 * @var ScoutGroup $scoutGroup
 */

use App\Model\Entity\ScoutGroup;
use App\View\AppView;

?>
<div class="row">
    <div class="col">
        <?= $this->element('image-header') ?>
        <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
            <div class="card-body">
                <div class="row">
                    <div class="col" style="margin-top: 10px;margin-bottom: 10px;">
                        <h4 style="font-family: 'Nunito Sans', sans-serif;"><?= h($scoutGroup->group_alias) ?></h4>
                        <h6 class="text-muted mb-2" style="font-family: 'Nunito Sans', sans-serif;"><?= h($scoutGroup->scout_group) ?></h6>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-3 d-lg-flex d-xl-flex justify-content-lg-end justify-content-xl-end" style="margin-top: 10px;margin-bottom: 15px;">
                        <div class="dropdown d-lg-none"><button class="btn btn-primary dropdown-toggle d-sm-block d-md-block" data-toggle="dropdown" aria-expanded="false" type="button">Actions&nbsp;</button>
                            <div class="dropdown-menu" role="menu"><a class="dropdown-item" role="presentation" href="#">First Item</a><a class="dropdown-item" role="presentation" href="#">Second Item</a><a class="dropdown-item" role="presentation" href="#">Third Item</a></div>
                        </div>
                        <div class="dropleft d-none d-sm-none d-lg-inline"><button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button" style="font-family: 'Nunito Sans', sans-serif;">Actions</button>
                            <div class="dropdown-menu dropdown-menu-right" role="menu"><a class="dropdown-item" role="presentation" href="#">First Item</a><a class="dropdown-item" role="presentation" href="#">Second Item</a><a class="dropdown-item" role="presentation" href="#">Third Item</a></div>
                        </div>
                    </div>
                </div>
                <?php if ($this->Identity->buildAndCheckCapability('VIEW', 'Sections')) : ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Section</th>
                                <th scope="col">Section Type</th>
                                <th scope="col">Meeting Day</th>
                                <th scope="col">Meeting Time</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($scoutGroup->leader_sections as $section) : ?>
                                    <tr>
                                        <td><?= $section->has($section::FIELD_SECTION) ? h($section->section) : '' ?></td>
                                        <?php if ($section->has($section::FIELD_SECTION_TYPE)) : ?>
                                            <td><?= $this->Identity->buildAndCheckCapability('VIEW', 'SectionTypes') ? $this->Html->link($section->section_type->section_type, ['controller' => 'SectionTypes', 'action' => 'view', $section->section_type->id]) :  $section->section_type->section_type ?></td>
                                        <?php else : ?>
                                            <td></td>
                                        <?php endif; ?>
                                        <td><?= h($section->meeting_weekday) ?></td>
                                        <td><?= !empty($section->meeting_start_time) ? h($section->meeting_start_time) . ' - ' . h($section->meeting_end_time) : '' ?></td>
                                        <td class="actions">
                                            <?= $this->Identity->buildAndCheckCapability('VIEW', 'Sections') ? $this->Html->link('<i class="fal fa-eye"></i>', ['controller' => 'Sections', 'action' => 'view', $section->id], ['title' => __('View Section'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                            <?= $this->Identity->buildAndCheckCapability('UPDATE', 'Sections') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['controller' => 'Sections', 'action' => 'edit', $section->id], ['title' => __('Edit Section'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                            <?= $this->Identity->buildAndCheckCapability('DELETE', 'Sections') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['controller' => 'Sections', 'action' => 'delete', $section->id], ['confirm' => __('Are you sure you want to delete # {0}?', $section->id), 'title' => __('Delete Section'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
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
            <?php foreach ($scoutGroup->committee_sections as $section) : ?>
                <div class="col-sm-12 col-lg-6">
                    <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
                        <div class="card-body">
                            <h5 style="font-family: 'Nunito Sans', sans-serif;"><?= $section->section ?></h5>
                            <?php foreach ($section->roles as $role) : ?>
                                <p class="card-text" style="font-family: 'Nunito Sans', sans-serif;"><strong><?= $role->role_type->role_type ?>:</strong> <?= $this->Html->link($role->user->full_name, ['controller' => 'Users', 'action' => 'view', $role->user->id]) ?></p>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="col-sm-12 col-lg-6">
                <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
                    <div class="card-body">
                        <h5 style="font-family: 'Nunito Sans', sans-serif;">Group Information</h5>
                        <?php if ($scoutGroup->hasValue($scoutGroup::FIELD_CHARITY_NUMBER)) : ?>
                        <p class="card-text"><strong>Charity Number:</strong>&nbsp;<?= h($scoutGroup->charity_number) ?></p>
                        <?php endif; ?>
                        <p class="card-text"><strong>Domain:</strong> <?= $this->Html->link($scoutGroup->clean_domain, $scoutGroup->group_domain) ?></p>
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
                        <li class="nav-item"><a class="nav-link" id="audit-tab" data-toggle="tab" href="#audit" role="tab" aria-controls="audit" aria-selected="false" style="font-family: 'Nunito Sans', sans-serif;">Changes to Group</a></li>
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
                                            <th scope="col">Leader Contact</th>
                                            <th scope="col">Section</th>
                                            <th scope="col">Role Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($scoutGroup->sections as $section) : ?>
                                            <?php foreach ($section->roles as $role) : ?>
                                                <tr>
                                                    <td><?= $role->user->full_name ?></td>
                                                    <td class="actions">
                                                        <?= $this->Identity->checkCapability('VIEW_ROLE') ? $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $role->id], ['title' => __('View Role'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                                        <?= $this->Identity->checkCapability('UPDATE_ROLE') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $role->id], ['title' => __('Edit Role'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                                        <?= $this->Identity->checkCapability('DELETE_ROLE') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $role->id], ['confirm' => __('Are you sure you want to delete # {0}?', $role->id), 'title' => __('Delete Role'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                                    </td>
                                                    <td><?= $this->Text->autoLinkEmails($role->has('user_contact') ? $role->user_contact->contact_field : $role->user->email) ?></td>
                                                    <td><?= $section->section ?></td>
                                                    <td><?= $role->has($role::FIELD_ROLE_TYPE) ? $role->role_type->role_type : '' ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ($this->Identity->checkCapability('HISTORY')) : ?>
                        <div class="tab-pane fade" id="audit" role="tabpanel" aria-labelledby="audit-tab">
                            <?php if (!empty($scoutGroup->audits)) : ?>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <tr>
                                            <th scope="col"><?= __('Audit Field') ?></th>
                                            <th scope="col"><?= __('Old Value') ?></th>
                                            <th scope="col"><?= __('New Value') ?></th>
                                            <th scope="col"><?= __('Changed By') ?></th>
                                            <th scope="col"><?= __('Change Date') ?></th>
                                        </tr>
                                        <?php foreach ($scoutGroup->audits as $audit) : ?>
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
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

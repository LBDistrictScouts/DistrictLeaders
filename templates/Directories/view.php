<?php
/**
 * @var AppView $this
 * @var \App\Model\Entity\Directory $directory
 */

use App\View\AppView;

?>
<div class="row">
    <div class="col">
        <?= $this->element('image-header') ?>
        <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
            <div class="card-body">
                <div class="row">
                    <div class="col" style="margin-top: 10px;margin-bottom: 10px;">
                        <h4 style="font-family: 'Nunito Sans', sans-serif;"><?= h($directory->directory) ?></h4>
                        <h6 class="text-muted mb-2" style="font-family: 'Nunito Sans', sans-serif;"><?= $directory->has('directory_type') ? $this->Html->link($directory->directory_type->directory_type, ['controller' => 'DirectoryTypes', 'action' => 'view', $directory->directory_type->id]) : '' ?></h6>
                    </div>
                    <?php if (!$directory->has($directory::FIELD_AUTHORISATION_TOKEN)) : ?>
                        <div class="col-sm-12 col-md-12 col-lg-4 col-xl-3 d-lg-flex d-xl-flex justify-content-lg-end justify-content-xl-end" style="margin-top: 10px;margin-bottom: 15px;">
                            <?= $this->Html->link('Authorise Directory', ['action' => 'auth', $directory->id], ['class' => 'btn btn-primary btn-lg btn-block']) ?>
                        </div>
                    <?php else : ?>
                        <div class="col-sm-12 col-md-12 col-lg-4 col-xl-3 d-lg-flex d-xl-flex justify-content-lg-end justify-content-xl-end" style="margin-top: 10px;margin-bottom: 15px;">
                            <div class="d-inline">
                                <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button">Actions</button>
                                <div class="dropdown-menu" role="menu">
                                    <?= $this->Identity->buildAndCheckCapability('CREATE', 'DirectoryUsers') ? $this->Form->postLink('Sync Directory', ['controller' => 'Directories', 'action' => 'populate', $directory->id], ['confirm' => __('Are you sure you want to Sync Directory: "{0}" customer key #{1}?', $directory->directory, $directory->customer_reference), 'title' => __('Sync Directory'), 'class' => 'dropdown-item', 'role' => 'presentation']) : '' ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if ($this->Identity->buildAndCheckCapability('VIEW', 'DirectoryDomains') && !empty($directory->directory_domains)) : ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col"><?= __('Directory Domain') ?></th>
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                                <th scope="col"><?= __('Ingest') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($directory->directory_domains as $directoryDomains) : ?>
                                <tr>
                                    <td><?= h($directoryDomains->directory_domain) ?></td>
                                    <td class="actions">
                                        <?= $this->Identity->buildAndCheckCapability('VIEW', 'DomainDirectories') ? $this->Html->link('<i class="fal fa-eye"></i>', ['controller' => 'DirectoryDomains', 'action' => 'view', $directoryDomains->id], ['title' => __('View Section'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                        <?= $this->Identity->buildAndCheckCapability('UPDATE', 'DomainDirectories') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['controller' => 'DirectoryDomains', 'action' => 'edit', $directoryDomains->id], ['title' => __('Edit Section'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                        <?= $this->Identity->buildAndCheckCapability('DELETE', 'DomainDirectories') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['controller' => 'DirectoryDomains', 'action' => 'delete', $directoryDomains->id], ['confirm' => __('Are you sure you want to delete # {0}?', $directoryDomains->id), 'title' => __('Delete Section'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                    </td>
                                    <td><?= $this->Icon->iconBoolean($directoryDomains->ingest) ?></td>
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
                        <h5 style="font-family: 'Nunito Sans', sans-serif;">Directory Information</h5>
                        <p class="card-text"><strong>Customer Reference:</strong> <?= h($directory->customer_reference ?? '') ?></p>
                        <p class="card-text"><strong>Active:</strong> <?= $this->Icon->iconBoolean($directory->active) ?></p>
                        <p class="card-text"><strong>Authorised:</strong> <?= $this->Icon->iconBoolean($directory->has($directory::FIELD_AUTHORISATION_TOKEN)) ?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($this->Identity->buildAndCheckCapability('VIEW', 'Roles') || $this->Identity->checkCapability('HISTORY') || $this->Identity->checkCapability('DIRECTORY')) : ?>
            <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
                <div class="card-header">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <?php if ($this->Identity->buildAndCheckCapability('VIEW', 'DirectoryUsers')) : ?>
                            <li class="nav-item"><a class="nav-link active" id="directory-users-tab" data-toggle="tab" href="#directory-users" role="tab" aria-controls="directory-users" aria-selected="true" style="font-family: 'Nunito Sans', sans-serif;">Directory Users</a></li>
                        <?php endif; ?>
                        <?php if ($this->Identity->buildAndCheckCapability('VIEW', 'DirectoryGroups')) : ?>
                            <li class="nav-item"><a class="nav-link" id="directory-groups-tab" data-toggle="tab" href="#directory-groups" role="tab" aria-controls="directory-groups" aria-selected="false" style="font-family: 'Nunito Sans', sans-serif;">Directory Groups</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        <?php if ($this->Identity->buildAndCheckCapability('VIEW', 'DirectoryUsers')) : ?>
                            <div class="tab-pane fade show active" id="directory-users" role="tabpanel" aria-labelledby="directory-users-tab">
                                <?php if (!empty($directory->directory_users)) : ?>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col"><?= __('Name') ?></th>
                                                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                                                    <th scope="col"><?= __('Primary Email') ?></th>
                                                    <th scope="col"><?= __('Directory User Reference') ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($directory->directory_users as $directoryUsers) : ?>
                                                <tr>
                                                    <td><?= h($directoryUsers->full_name) ?></td>
                                                    <td class="actions">
                                                        <?= $this->Identity->buildAndCheckCapability('VIEW', 'Users') && $directoryUsers->has('user_contact') ? $this->Html->link('<i class="fal fa-user"></i>', ['controller' => 'Users', 'action' => 'view', $directoryUsers->user_contact->user_id], ['title' => __('View Role'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                                        <?= $this->Identity->buildAndCheckCapability('VIEW', 'DirectoryUsers') ? $this->Html->link('<i class="fal fa-eye"></i>', ['controller' => 'DirectoryUsers', 'action' => 'view', $directoryUsers->id], ['title' => __('View Role'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                                        <?= $this->Identity->buildAndCheckCapability('DELETE', 'DirectoryUsers') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['controller' => 'DirectoryUsers', 'action' => 'delete', $directoryUsers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $directoryUsers->id), 'title' => __('Delete Role'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                                    </td>
                                                    <td><?= $this->Text->autoLinkEmails($directoryUsers->primary_email) ?></td>
                                                    <td><?= h($directoryUsers->directory_user_reference) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php else : ?>
                                    <p>No Users</p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($this->Identity->buildAndCheckCapability('VIEW', 'DirectoryGroups')) : ?>
                            <div class="tab-pane fade" id="directory-groups" role="tabpanel" aria-labelledby="directory-groups-tab">
                                <?php if (!empty($directory->directory_groups)) : ?>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <tr>
                                                <th scope="col"><?= __('Directory Group Name') ?></th>
                                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                                                <th scope="col"><?= __('Directory Group Email') ?></th>
                                                <th scope="col"><?= __('Directory Group Reference') ?></th>
                                            </tr>
                                            <?php foreach ($directory->directory_groups as $directoryGroups) : ?>
                                                <tr>
                                                    <td><?= h($directoryGroups->directory_group_name) ?></td>
                                                    <td class="actions">
                                                        <?= $this->Identity->buildAndCheckCapability('VIEW', 'DirectoryGroups') ? $this->Html->link('<i class="fal fa-eye"></i>', ['controller' => 'DirectoryGroups', 'action' => 'view', $directoryGroups->id], ['title' => __('View Role'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                                        <?= $this->Identity->buildAndCheckCapability('UPDATE', 'DirectoryGroups') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['controller' => 'DirectoryGroups', 'action' => 'edit', $directoryGroups->id], ['title' => __('Edit Role'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                                        <?= $this->Identity->buildAndCheckCapability('DELETE', 'DirectoryGroups') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['controller' => 'DirectoryGroups', 'action' => 'delete', $directoryGroups->id], ['confirm' => __('Are you sure you want to delete # {0}?', $directoryGroups->id), 'title' => __('Delete Role'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                                    </td>
                                                    <td><?= h($directoryGroups->directory_group_email) ?></td>
                                                    <td><?= h($directoryGroups->directory_group_reference) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </table>
                                    </div>
                                <?php else : ?>
                                    <p>No Groups</p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

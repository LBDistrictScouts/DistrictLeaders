<?php
/**
 * @var \App\View\AppView $this
 * @var array $crudList
 * @var array $models
 * @var array $capabilities
 * @var \App\Model\Entity\RoleType $roleType
 */

?>


<div class="row">
    <div class="col">
        <?= $this->element('image-header')  ?>
        <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
            <div class="card-body">
                <div class="row">
                    <div class="col" style="margin-top: 10px;margin-bottom: 10px;">
                        <h4><?= h($roleType->role_type) ?></h4>

                        <h6 class="text-muted mb-2"><strong>Role Abbreviation:</strong> <?= h($roleType->role_abbreviation) ?></h6>
                        <?php if ($roleType->has('section_type')) :
                            ?><h6 class="text-muted mb-2"><strong>Section Type:</strong> <?= $this->Identity->buildAndCheckCapability('VIEW', 'SectionTypes') ? $this->Html->link($roleType->section_type->section_type, ['controller' => 'SectionTypes', 'action' => 'view', $roleType->section_type->id]) : $roleType->section_type->section_type ?></h6><?php
                        endif; ?>
                        <?php if ($roleType->has('role_template')) :
                            ?><h6 class="text-muted mb-2"><strong>Role Template:</strong> <?= $this->Identity->buildAndCheckCapability('VIEW', 'RoleTemplates') ? $this->Html->link($roleType->role_template->role_template, ['controller' => 'RoleTemplates', 'action' => 'view', $roleType->role_template->id]) : $roleType->role_template->role_template ?></h6><?php
                        endif; ?>
                        <h6 class="text-muted mb-2"><strong>Level:</strong> <?= $this->Number->format($roleType->level) ?></h6>
                    </div>
                </div>
            </div>
        </div>
        <?php if (!empty($roleType->roles) && $this->Identity->buildAndCheckCapability('VIEW', 'Roles')) : ?>
        <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
            <div class="card-header">
                <h3>Roles</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Leader</th>
                                    <th scope="col">Leader Contact</th>
                                    <th scope="col">Section</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($roleType->roles as $role) : ?>
                                    <tr>
                                        <td><?= $this->Identity->buildAndCheckCapability('VIEW', 'Users') || $this->Identity->checkCapability('DIRECTORY') ? $this->Html->link($role->user->full_name, ['controller' => 'Users', 'action' => 'view', $role->user->id]) : $role->user->full_name ?></td>
                                        <td><?= $this->Text->autoLinkEmails($role->has('user_contact') ? $role->user_contact->contact_field : $role->user->email) ?></td>
                                        <td><?= $this->Identity->buildAndCheckCapability('VIEW', 'Sections', $role->section->scout_group_id, $role->section_id) ? $this->Html->link($role->section->section, ['controller' => 'Sections', 'action' => 'view', $role->section_id]) : $role->section->section ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php if (!empty($roleType->capabilities) && $this->Identity->buildAndCheckCapability('VIEW', 'Capabilities')) : ?>
            <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
                <div class="card-header">
                    <h3>Capabilities on Role</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="row">
                                <div class="col" style="margin-top: 10px;margin-bottom: 10px;">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Special</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <?php foreach ($capabilities['Special'] as $capability => $templated) : ?>
                                                            <span class="badge badge-<?= $templated ? 'success' : 'info' ?>"><?= h($capability) ?></span>
                                                        <?php endforeach; ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <p class="text-right"><span class="badge badge-success">Green Badges</span> are templated values. <span class="badge badge-info">Blue Badges</span> are manual values.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th><?= __('Model') ?></th>
                                            <th><?= __('Field') ?></th>
                                            <?php foreach ($crudList as $crud) : ?>
                                                <th><?= ucwords(strtolower($crud)) ?></th>
                                            <?php endforeach; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($models as $knownModel => $modelConfig) : ?>
                                            <tr>
                                                <td><?= $this->Inflection->space($knownModel) ?></td>
                                                <td></td>
                                                <?php foreach ($crudList as $crud) : ?>
                                                    <?php
                                                    if (key_exists($knownModel, $capabilities)) {
                                                        $modelMatrix = $capabilities[$knownModel];
                                                    } else {
                                                        $modelMatrix = [];
                                                    }

                                                    if (key_exists($crud, $modelMatrix) && $modelMatrix[$crud]) {
                                                        $isTemplate = '<icon class="fal fa-clipboard-check"></icon>';
                                                    } else {
                                                        $isTemplate = '<icon class="fal fa-check-circle"></icon>';
                                                    }
                                                    ?>
                                                    <td><?= key_exists($crud, $modelMatrix) ? $isTemplate : '' ?></td>
                                                <?php endforeach; ?>
                                            </tr>
                                            <?php if (key_exists($knownModel, $capabilities) && key_exists('fields', $capabilities[$knownModel])) : ?>
                                                <?php foreach ($capabilities[$knownModel]['fields'] as $field => $fieldCrud) : ?>
                                                    <tr>
                                                        <td></td>
                                                        <td><?= ucwords($this->Inflection->space(strtolower($field))) ?></td>
                                                        <?php foreach ($crudList as $crud) : ?>
                                                            <?php if ($crud != 'CHANGE') : ?>
                                                                <?php
                                                                if ($crud == 'UPDATE') {
                                                                    $crud = 'CHANGE';
                                                                }
                                                                    $isActive = '';
                                                                if ($crud == 'CREATE' || $crud == 'DELETE') {
                                                                    $isActive = '<icon class="fal fa-ellipsis-h"></icon>';
                                                                }

                                                                if (key_exists($crud, $fieldCrud) && $fieldCrud[$crud]) {
                                                                    $isTemplate = '<icon class="fal fa-clipboard-check"></icon>';
                                                                } else {
                                                                    $isTemplate = '<icon class="fal fa-check-circle"></icon>';
                                                                }
                                                                ?>
                                                                <td><?= key_exists($crud, $fieldCrud) ? $isTemplate :  $isActive ?></td>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>

                                    </tbody>
                                </table>
                                <p class="text-right"><icon class="fal fa-clipboard-check"></icon> is a templated value. <icon class="fal fa-check-circle"></icon> is a manual value.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

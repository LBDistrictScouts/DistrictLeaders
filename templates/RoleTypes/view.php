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
        <div class="jumbotron d-none d-sm-none d-md-flex d-lg-flex d-xl-flex" style="background-image: url(/img/activity-bg-2.jpg);background-size: cover;height: 300px;"></div>
        <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
            <div class="card-body">
                <div class="row">
                    <div class="col" style="margin-top: 10px;margin-bottom: 10px;">
                        <h4><?= h($roleType->role_type) ?></h4>

                        <h6 class="text-muted mb-2"><strong>Role Abbreviation:</strong> <?= h($roleType->role_abbreviation) ?></h6>
                        <h6 class="text-muted mb-2"><strong>Section Type:</strong> <?= $roleType->has('section_type') ? $this->Html->link($roleType->section_type->section_type, ['controller' => 'SectionTypes', 'action' => 'view', $roleType->section_type->id]) : '' ?></h6>
                        <h6 class="text-muted mb-2"><strong>Role Template:</strong> <?= $roleType->has('role_template') ? $this->Html->link($roleType->role_template->role_template, ['controller' => 'RoleTemplates', 'action' => 'view', $roleType->role_template->id]) : '' ?></h6>
                        <h6 class="text-muted mb-2"><strong>Level:</strong> <?= $this->Number->format($roleType->level) ?></h6>
                    </div>
                </div>
            </div>
        </div>
        <?php if (!empty($roleType->capabilities)) : ?>
            <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
                <div class="card-header">
                    <h3>Capabilities on Role</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col" style="margin-top: 10px;margin-bottom: 10px;">
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

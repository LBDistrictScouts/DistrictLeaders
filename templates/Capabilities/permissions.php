<?php
/**
 * @var \App\View\AppView $this
 * @var array $capabilities
 * @var array $models
 * @var \App\Model\Entity\User $user
 */
?>


<div class="row">
    <div class="col">
        <div class="jumbotron d-none d-sm-none d-md-flex d-lg-flex d-xl-flex" style="background-image: url(/img/activity-bg-2.jpg);background-size: cover;height: 300px;"></div>
        <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
            <div class="card-body">
                <div class="row">
                    <div class="col" style="margin-top: 10px;margin-bottom: 10px;">
                        <h4><?= h($user->full_name) ?></h4>

                        <h6 class="text-muted mb-2"><strong>User ID:</strong> <?= h($user->id) ?></h6>
                        <h6 class="text-muted mb-2"><strong>Username:</strong> <?= h($user->username) ?></h6>
                        <h6 class="text-muted mb-2"><strong>Primary Email:</strong> <?= h($user->email) ?></h6>
                    </div>
                </div>
                <?php if (!empty($capabilities) && !empty($capabilities['User'])) : ?>
                    <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
                        <div class="card-header">
                            <h3>User Level</h3>
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
                                                                <?php foreach ($capabilities['User']['Special'] as $capability) : ?>
                                                                    <span class="badge badge-info"><?= h($capability) ?></span>
                                                                <?php endforeach; ?>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th><?= __('Model') ?></th>
                                                    <th><?= __('Field') ?></th>
                                                    <?php foreach ($capabilities['CRUD'] as $crud) : ?>
                                                        <?php if ($crud != 'CHANGE') : ?>
                                                            <th><?= ucwords(strtolower($crud)) ?></th>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($models as $knownModel => $modelConfig) : ?>
                                                    <tr>
                                                        <td><?= $this->Inflection->space($knownModel) ?></td>
                                                        <td></td>
                                                        <?php foreach ($capabilities['CRUD'] as $crud) : ?>
                                                            <?php if ($crud != 'CHANGE') : ?>
                                                                <?php
                                                                if (key_exists($knownModel, $capabilities['User'])) {
                                                                    $modelMatrix = $capabilities['User'][$knownModel];
                                                                } else {
                                                                    $modelMatrix = [];
                                                                }
                                                                ?>
                                                                <td><?= key_exists($crud, $modelMatrix) && $modelMatrix[$crud] ? '<icon class="fal fa-check-circle"></icon>' : '' ?></td>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </tr>
                                                    <?php if (key_exists($knownModel, $capabilities['User']) && key_exists('fields', $capabilities['User'][$knownModel])) : ?>
                                                        <?php foreach ($capabilities['User'][$knownModel]['fields'] as $field => $fieldCrud) : ?>
                                                            <tr>
                                                                <td></td>
                                                                <td><?= ucwords($this->Inflection->space(strtolower($field))) ?></td>
                                                                <?php foreach ($capabilities['CRUD'] as $crud) : ?>
                                                                    <?php if ($crud != 'CHANGE') : ?>
                                                                        <?php
                                                                        if ($crud == 'UPDATE') {
                                                                            $crud = 'CHANGE';
                                                                        }
                                                                            $isActive = '';
                                                                        if ($crud == 'CREATE' || $crud == 'DELETE') {
                                                                            $isActive = '<icon class="fal fa-ellipsis-h"></icon>';
                                                                        }
                                                                        ?>
                                                                        <td><?= key_exists($crud, $fieldCrud) && $fieldCrud[$crud] ? '<icon class="fal fa-check-circle"></icon>' :  $isActive ?></td>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php
                    $nonUserCapabilities = $capabilities;
                    unset($nonUserCapabilities['CRUD']);
                    unset($nonUserCapabilities['User']);
                    ksort($nonUserCapabilities);
                ?>

                <?php if (!empty($nonUserCapabilities)) : ?>
                    <?php foreach ($nonUserCapabilities as $capabilityMatrixArray) : ?>
                        <?php $entity = $capabilityMatrixArray['object']; ?>
                                                                                                                                  /** @var \App\Model\Entity\Section|\App\Model\Entity\ScoutGroup  $entity */ ?>
                        <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
                            <div class="card-header">
                                <?php if ($entity instanceof \App\Model\Entity\Section) : ?>
                                    <h3>Section: <?= $this->Html->link($entity->section, ['controller' => 'Sections', 'action' => 'view', $entity->id]) ?></h3>
                                <?php endif; ?>
                                <?php if ($entity instanceof \App\Model\Entity\ScoutGroup) : ?>
                                    <h3>Scout Group: <?= $this->Html->link($entity->scout_group, ['controller' => 'ScoutGroups', 'action' => 'view', $entity->id]) ?></h3>
                                <?php endif; ?>
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
                                                                <?php foreach ($capabilityMatrixArray['Special'] as $capability) : ?>
                                                                    <span class="badge badge-info"><?= h($capability) ?></span>
                                                                <?php endforeach; ?>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th><?= __('Model') ?></th>
                                                    <th><?= __('Field') ?></th>
                                                    <?php foreach ($capabilities['CRUD'] as $crud) : ?>
                                                        <?php if ($crud != 'CHANGE') : ?>
                                                            <th><?= ucwords(strtolower($crud)) ?></th>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($models as $knownModel => $modelConfig) : ?>
                                                    <tr>
                                                        <td><?= $this->Inflection->space($knownModel) ?></td>
                                                        <td></td>
                                                        <?php foreach ($capabilities['CRUD'] as $crud) : ?>
                                                            <?php if ($crud != 'CHANGE') : ?>
                                                                <?php
                                                                if (key_exists($knownModel, $capabilityMatrixArray)) {
                                                                    $modelMatrix = $capabilityMatrixArray[$knownModel];
                                                                } else {
                                                                    $modelMatrix = [];
                                                                }
                                                                ?>
                                                                <td><?= key_exists($crud, $modelMatrix) && $modelMatrix[$crud] ? '<icon class="fal fa-check-circle"></icon>' : '' ?></td>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </tr>
                                                    <?php if (key_exists($knownModel, $capabilityMatrixArray) && key_exists('fields', $capabilityMatrixArray[$knownModel])) : ?>
                                                        <?php foreach ($capabilityMatrixArray[$knownModel]['fields'] as $field => $fieldCrud) : ?>
                                                            <tr>
                                                                <td></td>
                                                                <td><?= ucwords($this->Inflection->space(strtolower($field))) ?></td>
                                                                <?php foreach ($capabilities['CRUD'] as $crud) : ?>
                                                                    <?php if ($crud != 'CHANGE') : ?>
                                                                        <?php
                                                                        if ($crud == 'UPDATE') {
                                                                            $crud = 'CHANGE';
                                                                        }
                                                                        $isActive = '';
                                                                        if ($crud == 'CREATE' || $crud == 'DELETE') {
                                                                            $isActive = '<icon class="fal fa-ellipsis-h"></icon>';
                                                                        }
                                                                        ?>
                                                                        <td><?= key_exists($crud, $fieldCrud) && $fieldCrud[$crud] ? '<icon class="fal fa-check-circle"></icon>' :  $isActive ?></td>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

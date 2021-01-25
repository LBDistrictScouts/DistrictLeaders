<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CompassRecord $compassRecord
 * @var \App\Model\Entity\User $user
 * @var string $mergeStatus
 */
?>
<div class="row">
    <div class="col">
        <?= $this->element('image-header') ?>
        <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
            <div class="card-body">
                <div class="row">
                    <div class="col" style="margin-top: 10px;margin-bottom: 10px;">
                        <h4 style="font-family: 'Nunito Sans', sans-serif;"><?= h($compassRecord->full_name) ?></h4>
                        <h6 class="text-muted mb-2" style="font-family: 'Nunito Sans', sans-serif;"></h6>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-3 d-lg-flex d-xl-flex justify-content-lg-end justify-content-xl-end" style="margin-top: 10px;margin-bottom: 15px;">
                        <div class="dropdown d-lg-none"><button class="btn btn-primary dropdown-toggle d-sm-block d-md-block" data-toggle="dropdown" aria-expanded="false" type="button">Actions&nbsp;</button>
                            <div class="dropdown-menu" role="menu">
                                <?= $this->Identity->buildAndCheckCapability('UPDATE', 'CompassRecords') ? $this->Html->link('<i class="fal fa-pencil"></i> Edit Record', ['controller' => 'CompassRecords', 'action' => 'edit', $compassRecord->id], ['title' => __('Edit Compass Record'), 'class' => 'dropdown-item', 'role' => 'presentation', 'escape' => false]) : '' ?>
                                <?= $this->Identity->buildAndCheckCapability('UPDATE', 'Users') && isset($user) && !empty($user) && $user instanceof \App\Model\Entity\User ? $this->Html->link('<i class="fal fa-code-merge"></i> Merge User', ['controller' => 'CompassRecords', 'action' => 'merge', $compassRecord->id, $user->id], ['title' => __('Link Compass Record to User'), 'class' => 'dropdown-item', 'role' => 'presentation', 'escape' => false]) : '' ?>
                                <?= $this->Identity->buildAndCheckCapability('CREATE', 'Users') && ( !isset($user) || empty($user) || !$user instanceof \App\Model\Entity\User ) ? $this->Form->postLink('<i class="fal fa-inbox-in"></i> Consume Compass Record', ['controller' => 'CompassRecords', 'action' => 'consume', $compassRecord->id], ['confirm' => __('Are you sure you want to consume record #{0}, for user {1}?', $compassRecord->id, $compassRecord->full_name), 'title' => __('Consume Compass Record'), 'class' => 'dropdown-item', 'role' => 'presentation', 'escape' => false]) : '' ?>
                            </div>
                        </div>
                        <div class="dropleft d-none d-sm-none d-lg-inline"><button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button" style="font-family: 'Nunito Sans', sans-serif;">Actions</button>
                            <div class="dropdown-menu dropdown-menu-right" role="menu">
                                <?= $this->Identity->buildAndCheckCapability('UPDATE', 'CompassRecords') ? $this->Html->link('<i class="fal fa-pencil"></i> Edit Record', ['controller' => 'CompassRecords', 'action' => 'edit', $compassRecord->id], ['title' => __('Edit Compass Record'), 'class' => 'dropdown-item', 'role' => 'presentation', 'escape' => false]) : '' ?>
                                <?= $this->Identity->buildAndCheckCapability('UPDATE', 'Users') && isset($user) && !empty($user) && $user instanceof \App\Model\Entity\User ? $this->Html->link('<i class="fal fa-code-merge"></i> Merge User', ['controller' => 'CompassRecords', 'action' => 'merge', $compassRecord->id, $user->id], ['title' => __('Link Compass Record to User'), 'class' => 'dropdown-item', 'role' => 'presentation', 'escape' => false]) : '' ?>
                                <?= $this->Identity->buildAndCheckCapability('CREATE', 'Users') && ( !isset($user) || empty($user) || !$user instanceof \App\Model\Entity\User ) ? $this->Form->postLink('<i class="fal fa-inbox-in"></i> Consume Compass Record', ['controller' => 'CompassRecords', 'action' => 'consume', $compassRecord->id], ['confirm' => __('Are you sure you want to consume record #{0}, for user {1}?', $compassRecord->id, $compassRecord->full_name), 'title' => __('Consume Compass Record'), 'class' => 'dropdown-item', 'role' => 'presentation', 'escape' => false]) : '' ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col" style="margin-top: 10px;margin-bottom: 10px;">
                        <h6 class="text-muted mb-2"><?= $this->Html->link($compassRecord->document_version->document->document . ' (v' . $compassRecord->document_version->version_number . ')', ['controller' => 'Documents', 'action' => 'view', $compassRecord->document_version->document->id]) ?></h6>
                        <br />
                        <?php if ($mergeStatus == 'Merge') : ?>
                        <div class="alert alert-success">Record is ready for Merging.</div>
                        <?php else : ?>
                        <div class="alert alert-danger"><?= $mergeStatus ?></div>
                        <?php endif; ?>
                        <div class="table-responsive table-hover">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th scope="col">Membership Number</th>
                                        <td><?= $compassRecord->membership_number ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Email</th>
                                        <td><?= $compassRecord->email ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Phone</th>
                                        <td><?= $compassRecord->phone ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Address</th>
                                        <td><?= $compassRecord->address ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
            <div class="card-body">
                <div class="row">
                    <div class="col" style="margin-top: 10px;margin-bottom: 10px;">
                        <div class="table-responsive table-hover">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Role</th>
                                    <th scope="col">Section Type</th>
                                    <th scope="col">Group</th>
                                    <th scope="col">Section</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?= $compassRecord->clean_role ?></td>
                                        <td><?= $compassRecord->clean_section_type ?></td>
                                        <td><?= $compassRecord->clean_group ?></td>
                                        <td><?= $compassRecord->clean_section ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if (isset($user) && !empty($user) && $user instanceof \App\Model\Entity\User) : ?>
            <div class="row">
                <div class="col-sm-12 col-lg-6">
                    <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
                        <div class="card-body">
                            <h4>Predicted Record</h4>
                            <br/>
                            <p class="card-text"><strong>First Name:</strong> <?= h($user->first_name) ?></p>
                            <p class="card-text"><strong>Last Name:</strong> <?= h($user->last_name) ?></p>
                            <p class="card-text"><strong>Primary Email:</strong> <?= $this->Text->autoLinkEmails($user->email) ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-6">
                    <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
                        <div class="card-body">
                            <h4>Compass Record</h4>
                            <br/>
                            <p class="card-text"><strong>First Name:</strong> <?= h($compassRecord->first_name) ?></p>
                            <p class="card-text"><strong>Last Name:</strong> <?= h($compassRecord->last_name) ?></p>
                            <p class="card-text"><strong>Primary Email:</strong> <?= $this->Text->autoLinkEmails($compassRecord->email) ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <?= $this->Html->link('Merge User', ['controller' => 'CompassRecords', 'action' => 'merge', $compassRecord->id, $user->id], ['class' => 'btn btn-primary btn-lg btn-block']) ?>
                </div>
            </div>
        <?php else : ?>
            <div class="row">
                <div class="col">
                    <?= $this->Identity->buildAndCheckCapability('CREATE', 'Users') ? $this->Form->postLink('Consume Compass Record', ['controller' => 'CompassRecords', 'action' => 'consume', $compassRecord->id], ['confirm' => __('Are you sure you want to consume record #{0}, for user {1}?', $compassRecord->id, $compassRecord->full_name), 'title' => __('Consume Compass'), 'class' => 'btn btn-primary btn-lg btn-block', 'role' => 'presentation']) : '' ?>
                </div>
            </div>
        <?php endif; ?>



    </div>
</div>

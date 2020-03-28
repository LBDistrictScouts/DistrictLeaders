<?php
/**
 * @var \App\View\AppView $this
 */

$user = $this->Identity->get();
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
                <?php if (!empty($user->capabilities)): ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th><?= __('Level') ?></th>
                                <th><?= __('Capability') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($user->capabilities['user'])): ?>
                                    <tr>
                                        <td>User</td>
                                        <td>
                                            <?php foreach ($user->capabilities['user'] as $capability): ?>
                                                <span class="badge badge-info"><?= h($capability) ?></span>
                                            <?php endforeach; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (!empty($user->capabilities['group'])): ?>
                                    <tr>
                                        <td>Group</td>
                                        <td>
                                            <?php foreach ($user->capabilities['group'] as $capability): ?>
                                                <span class="badge badge-info"><?= h($capability) ?></span>
                                            <?php endforeach; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (!empty($user->capabilities['section'])): ?>
                                    <tr>
                                        <td>Section</td>
                                        <td>
                                            <?php foreach ($user->capabilities['section'] as $capability): ?>
                                                <span class="badge badge-info"><?= h($capability) ?></span>
                                            <?php endforeach; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

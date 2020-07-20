<?php
/**
 * @var \App\View\AppView $this
 * @var \Google_Service_Directory_Users $googleUsers
 * @var array $domainList
 */

?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3>Directory Users</h3>
            </div>
            <div class="card-body">
                <?= $this->Form->create(null, ['type' => 'get']) ?>
                <?= $this->Form->select('domain', $domainList) ?>
                <?= $this->Form->submit() ?>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Primary Email</th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($googleUsers->getUsers() as $user) : ?>
                            <?php /** @var \Google_Service_Directory_User $user */ ?>
                            <tr>
                                <td><?= h($user->getName()->getFullName()) ?></td>
                                <td><?= h($user->getPrimaryEmail()) ?></td>
                                <td class="actions">
                                    <?= $this->Identity->checkCapability('CREATE_USER') ? $this->Html->link('<i class="fal fa-check"></i>', ['prefix' => false, 'controller' => 'Users', 'action' => 'import', $user->getId()], ['title' => __('View Camp Type'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                    <?= $this->Identity->checkCapability('VIEW_USER') ? $this->Html->link('<i class="fal fa-eye"></i>', ['prefix' => false, 'controller' => 'Users', 'action' => 'view', $user->getId()], ['title' => __('Edit Camp Type'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

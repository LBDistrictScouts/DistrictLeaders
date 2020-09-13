<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DirectoryUser $directoryUser
 * @var \App\Model\Entity\User $user
 */

use App\Model\Entity\User;

?>
<div class="row">
    <div class="col">
        <?= $this->element('image-header') ?>
        <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
            <div class="card-body">
                <div class="row">
                    <div class="col" style="margin-top: 10px;margin-bottom: 10px;">
                        <h4><?= $directoryUser->full_name ?></h4>
                        <h6 class="text-muted mb-2"><?= $this->Html->link($directoryUser->directory->directory, ['controller' => 'Directories', 'action' => 'view', $directoryUser->directory->id]) ?></h6>
                    </div>
                </div>
            </div>
        </div>
        <?php if (!empty($directoryUser->users)) : ?>
            <div class="row">
                <div class="col">
                    <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
                        <div class="card-body">
                            <h4>Connected Record</h4>
                            <br/>
                            <?php foreach ($directoryUser->users as $connectedUser) : ?>
                                <p class="card-text"><strong>Email:</strong> <?= $this->Text->autoLinkEmails($connectedUser->_joinData->contact_field) ?></p>
                            <?php endforeach; ?>
                            <p class="card-text"><strong>First Name:</strong> <?= h($connectedUser->first_name) ?></p>
                            <p class="card-text"><strong>Last Name:</strong> <?= h($connectedUser->last_name) ?></p>
                        </div>
                    </div>
                    <?= $this->Html->link('View Linked User', ['controller' => 'Users', 'action' => 'view', $connectedUser->id], ['class' => 'btn btn-primary btn-lg btn-block']) ?>
                </div>
            </div>
        <?php else : ?>
            <div class="row">
                <?php if (isset($user) && !empty($user) && $user instanceof User) : ?>
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
                <?php endif; ?>
                <div class="col-sm-12 col-lg-6">
                    <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
                        <div class="card-body">
                            <h4>Directory Record</h4>
                            <br/>
                            <p class="card-text"><strong>First Name:</strong> <?= h($directoryUser->given_name) ?></p>
                            <p class="card-text"><strong>Last Name:</strong> <?= h($directoryUser->family_name) ?></p>
                            <p class="card-text"><strong>Primary Email:</strong> <?= $this->Text->autoLinkEmails($directoryUser->primary_email) ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (isset($user) && !empty($user) && $user instanceof User) : ?>
            <div class="row">
                <div class="col">
                    <?= $this->Html->link('Link User', ['action' => 'link', $directoryUser->id, $user->id], ['class' => 'btn btn-primary btn-lg btn-block']) ?>
                </div>
            </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>


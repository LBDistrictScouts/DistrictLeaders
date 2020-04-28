<?php
/**
 * @var \App\View\AppView $this
 * @var array $capabilities
 * @var int $loggedInUserId
 * @var string $name
 */
?>
<!-- Modal -->
<div class="modal fade" id="profile" tabindex="5" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php if (isset($loggedInUserId) && is_integer($loggedInUserId)) : ?>
                <div class="modal-body">
                    <?= $this->Html->link('View Details', ['controller' => 'Users', 'action' => 'view', $loggedInUserId], ['class' => 'dropdown-item'])  ?>
                    <?= $this->Html->link('View Permissions', ['controller' => 'Pages', 'action' => 'display', 'permissions'], ['class' => 'dropdown-item'])  ?>
                    <?= $this->Html->link('Edit Details', ['controller' => 'Users', 'action' => 'edit', $loggedInUserId], ['class' => 'dropdown-item'])  ?>
                    <?= $this->Html->link('Change Password', ['controller' => 'Users', 'action' => 'password', $loggedInUserId], ['class' => 'dropdown-item'])  ?>
                    <div class="dropdown-divider"></div>
                    <?= $this->Html->link('Logout', ['controller' => 'Users', 'action' => 'logout'], ['class' => 'dropdown-item'])  ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

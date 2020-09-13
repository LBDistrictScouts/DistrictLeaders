<?php
/**
 * @var \App\View\AppView $this
 * @var array $userStateArray
 * @var \App\Model\Entity\User $user
 */

if (isset($userStateArray)) : ?>
    <div class="table-responsive">
        <table class="table table-borderless table-hover" id="modal-notify-table">
            <tbody>
                <tr>
                    <th scope="col">Evaluation</th>
                    <th scope="col">Value</th>
                </tr>
                <tr>
                    <td>Can Receive Emails</td>
                    <td><?= $this->Icon->iconBoolean($user->user_state->is_email_send_active) ?></td>
                </tr>
                <?php foreach ($userStateArray as $stateKey => $stateValue) : ?>
                <tr>
                    <td><?= $stateKey ?></td>
                    <td><?= $this->Icon->iconBoolean($stateValue) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

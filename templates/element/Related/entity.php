<?php
/**
 * @var AppView $this
 * @var User $user
 */
declare(strict_types=1);

/**
 * @var AppView $this
 * @var User $user
 */

use App\Model\Entity\User;
use App\View\AppView;

?>
<?php if (!empty($user->changes)) : ?>
    <div class="collapse" id="recentChanges" data-parent="#related">
        <div class="card">
            <div class="card-header">
                <h4><?= __('Recent Changes') ?></h4>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <th scope="col"><?= __('Changed User') ?></th>
                            <th scope="col"><?= __('Audit Field') ?></th>
                            <th scope="col"><?= __('Old Value') ?></th>
                            <th scope="col"><?= __('New Value') ?></th>
                            <th scope="col"><?= __('Change Date') ?></th>
                        </tr>
                        <?php foreach ($user->changes as $audit) : ?>
                            <tr>
                                <td><?= $audit->has('changed_user') ? $this->Html->link($audit->changed_user->full_name, ['controller' => 'Users', 'action' => 'view', $audit->changed_user->id]) : '' ?></td>
                                <td><?= $this->Inflection->space($audit->audit_field) ?></td>
                                <td><?= h($audit->original_value) ?></td>
                                <td><?= h($audit->modified_value) ?></td>
                                <td><?= $this->Time->format($audit->change_date, 'dd-MMM-yy HH:mm') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

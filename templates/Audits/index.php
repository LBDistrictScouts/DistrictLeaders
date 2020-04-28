<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Audit[]|\Cake\Collection\CollectionInterface $audits
 */

$this->extend('../layout/CRUD/index');

$this->assign('entity', 'Changes');
$this->assign('subset', 'Recent');
$this->assign('icon', 'fa-exchange');
$this->assign('add', 'No');

?>

<thead>
<tr>
    <th scope="col"><?= $this->Paginator->sort(\App\Model\Entity\Audit::FIELD_CHANGED_USER) ?></th>
    <th scope="col"><?= $this->Paginator->sort(\App\Model\Entity\Audit::FIELD_AUDIT_FIELD) ?></th>
    <th scope="col"><?= $this->Paginator->sort(\App\Model\Entity\Audit::FIELD_ORIGINAL_VALUE, 'Old Value') ?></th>
    <th scope="col"><?= $this->Paginator->sort(\App\Model\Entity\Audit::FIELD_MODIFIED_VALUE, 'New Value') ?></th>
    <th scope="col"><?= $this->Paginator->sort(\App\Model\Entity\Audit::FIELD_USER_ID, 'Changed By') ?></th>
    <th scope="col"><?= $this->Paginator->sort(\App\Model\Entity\Audit::FIELD_CHANGE_DATE) ?></th>
    <th scope="col" class="actions"><?= __('Actions') ?></th>
</tr>
</thead>
<tbody>
<?php foreach ($audits as $audit): ?>
    <tr>
        <td><?= $audit->has('changed_user') ? $this->Html->link($audit->changed_user->full_name, ['controller' => 'Users', 'action' => 'view', $audit->changed_user->id]) : '' ?></td>
        <td><?= $this->Inflection->space($audit->audit_field) ?></td>
        <td><?= h($audit->original_value) ?></td>
        <td><?= h($audit->modified_value) ?></td>
        <td><?= $audit->has('user') ? $this->Html->link($audit->user->full_name, ['controller' => 'Users', 'action' => 'view', $audit->user->id]) : '' ?></td>
        <td><?= $this->Time->format($audit->change_date,'dd-MMM-yy HH:mm') ?></td>
        <td class="actions">
            <?= $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $audit->id], ['title' => __('View'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) ?>
        </td>
    </tr>
<?php endforeach; ?>
</tbody>

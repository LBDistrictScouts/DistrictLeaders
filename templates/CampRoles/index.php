<?php
/**
 * @var AppView $this
 * @var CampRole[]|CollectionInterface $campRoles
 */

use App\Model\Entity\CampRole;
use App\View\AppView;
use Cake\Collection\CollectionInterface;

$this->extend('../layout/CRUD/index');

$this->assign('entity', 'CampRoles');
$this->assign('subset', 'All');
$this->assign('add', $this->Identity->checkCapability('CREATE_CAMP_ROLE'));

?>
<thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('id') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
        <th scope="col"><?= $this->Paginator->sort('created') ?></th>
        <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
        <th scope="col"><?= $this->Paginator->sort('camp_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
        <th scope="col"><?= $this->Paginator->sort('camp_role_type_id') ?></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($campRoles as $campRole) : ?>
    <tr>
        <td><?= h($campRole->id) ?></td>
                <td class="actions">
            <?= $this->Identity->checkCapability('VIEW_CAMP_ROLE') ? $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $campRole->id], ['title' => __('View Camp Role'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('UPDATE_CAMP_ROLE') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $campRole->id], ['title' => __('Edit Camp Role'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('DELETE_CAMP_ROLE') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $campRole->id], ['confirm' => __('Are you sure you want to delete # {0}?', $campRole->id), 'title' => __('Delete Camp Role'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
        </td>
        <td><?= h($campRole->created) ?></td>
        <td><?= h($campRole->modified) ?></td>
        <td><?= $this->Number->format($campRole->camp_id) ?></td>
        <td><?= $this->Number->format($campRole->user_id) ?></td>
        <td><?= $this->Number->format($campRole->camp_role_type_id) ?></td>
    </tr>
    <?php endforeach; ?>
</tbody>

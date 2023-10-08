<?php
/**
 * @var AppView $this
 * @var \App\Model\Entity\RoleTemplate[]|CollectionInterface $roleTemplates
 */

use App\View\AppView;
use Cake\Collection\CollectionInterface;

$this->extend('../layout/CRUD/index');

$this->assign('entity', 'RoleTemplates');
$this->assign('subset', 'All');
$this->assign('add', $this->Identity->checkCapability('CREATE_ROLE_TEMPLATE'));

?>
<thead>
    <tr>
        <th scope="col"><?= $this->Paginator->sort('role_template') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
        <th scope="col"><?= $this->Paginator->sort('indicative_level') ?></th>
    </tr>
</thead>
<tbody>
    <?php foreach ($roleTemplates as $roleTemplate) : ?>
    <tr>
        <td><?= h($roleTemplate->role_template) ?></td>
                <td class="actions">
            <?= $this->Identity->checkCapability('VIEW_ROLE_TEMPLATE') ? $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $roleTemplate->id], ['title' => __('View Role Template'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('UPDATE_ROLE_TEMPLATE') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $roleTemplate->id], ['title' => __('Edit Role Template'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('DELETE_ROLE_TEMPLATE') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $roleTemplate->id], ['confirm' => __('Are you sure you want to delete # {0}?', $roleTemplate->id), 'title' => __('Delete Role Template'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
        </td>
        <td><?= $this->Number->format($roleTemplate->indicative_level) ?></td>
    </tr>
    <?php endforeach; ?>
</tbody>

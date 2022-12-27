<?php
/**
 * @var AppView $this
 * @var User[]|CollectionInterface $users
 * @var Section[]|CollectionInterface $sections
 */

/**
 * @var AppView $this
 * @var Section[]|CollectionInterface $sections
 */

use App\Model\Entity\Section;
use App\Model\Entity\User;
use App\View\AppView;
use Cake\Collection\CollectionInterface;

$this->extend('../layout/CRUD/search');

$this->assign('entity', 'Sections');
$this->assign('subset', 'Found');
$this->assign('add', $this->Identity->buildAndCheckCapability('CREATE', 'Sections'))

?>
<thead>
<tr>
    <th scope="col"><?= $this->Paginator->sort('section') ?></th>
    <th scope="col" class="actions"><?= __('Actions') ?></th>
    <th scope="col"><?= $this->Paginator->sort('section_type_id') ?></th>
    <th scope="col"><?= $this->Paginator->sort('scout_group_id') ?></th>
    <th scope="col"><?= $this->Paginator->sort('meeting_day', 'Meeting Weekday') ?></th>
    <th scope="col"><?= $this->Paginator->sort('meeting_start_time', 'Meeting Time') ?></th>
</tr>
</thead>
<tbody>
<?php foreach ($sections as $section) : ?>
    <tr>
        <td><?= h($section->section) ?></td>
        <td class="actions">
            <?= $this->Identity->checkCapability('VIEW_SECTION') ? $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $section->id], ['title' => __('View Section'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('UPDATE_SECTION') ? $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $section->id], ['title' => __('Edit Section'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->checkCapability('DELETE_SECTION') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $section->id], ['confirm' => __('Are you sure you want to delete # {0}?', $section->id), 'title' => __('Delete Section'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
        </td>
        <td><?= $section->has('section_type') ? $this->Html->link($section->section_type->section_type, ['controller' => 'SectionTypes', 'action' => 'view', $section->section_type->id]) : '' ?></td>
        <td><?= $section->has('scout_group') ? $this->Html->link($section->scout_group->group_alias, ['controller' => 'ScoutGroups', 'action' => 'view', $section->scout_group->id]) : '' ?></td>
        <td><?= h($section->meeting_weekday) ?></td>
        <td><?= !empty($section->meeting_start_time) ? h($section->meeting_start_time) . ' - ' . h($section->meeting_end_time) : '' ?></td>
    </tr>
<?php endforeach; ?>
</tbody>

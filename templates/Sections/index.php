<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Section[]|\Cake\Collection\CollectionInterface $sections
 * @var \App\Model\Entity\User $authUser
 */

$this->extend('../layout/CRUD/index');

$this->assign('entity', 'Sections');
$this->assign('subset', 'All');
$this->assign('add', $this->Identity->checkCapability('CREATE_SECTION'));

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
            <?= $this->Identity->buildAndCheckCapability('VIEW', 'Sections', $this->Identity->groups, $section->id) ? $this->Html->link('<i class="fal fa-eye"></i>', ['action' => 'view', $section->id], ['title' => __('View Section'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->buildAndCheckCapability('UPDATE', 'Sections', $this->Identity->groups, $section->id) ? $this->Html->link('<i class="fal fa-pencil"></i>', ['action' => 'edit', $section->id], ['title' => __('Edit Section'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
            <?= $this->Identity->buildAndCheckCapability('DELETE', 'Sections', $this->Identity->groups, $section->id) ? $this->Form->postLink('<i class="fal fa-trash-alt"></i>', ['action' => 'delete', $section->id], ['confirm' => __('Are you sure you want to delete # {0}?', $section->id), 'title' => __('Delete Section'), 'class' => 'btn btn-default btn-sm', 'escape' => false]) : '' ?>
        </td>
        <?php
            $sectionTypeLink = $this->Identity->buildAndCheckCapability('VIEW', 'SectionTypes') ? $this->Html->link($section->section_type->section_type, ['controller' => 'SectionTypes', 'action' => 'view', $section->section_type->id]) : $section->section_type->section_type;
            $scoutGroupLink = $this->Identity->buildAndCheckCapability('VIEW', 'ScoutGroups', $section->scout_group->id, $section->id) ? $this->Html->link($section->scout_group->group_alias, ['controller' => 'ScoutGroups', 'action' => 'view', $section->scout_group->id]) : $section->scout_group->group_alias;
        ?>
        <td><?= $section->has('section_type') ? $sectionTypeLink : '' ?></td>
        <td><?= $section->has('scout_group') ? $scoutGroupLink : '' ?></td>
        <td><?= h($section->meeting_weekday) ?></td>
        <td><?= !empty($section->meeting_start_time) ? h($section->meeting_start_time) . ' - ' . h($section->meeting_end_time) : '' ?></td>
    </tr>
    <?php endforeach; ?>
</tbody>

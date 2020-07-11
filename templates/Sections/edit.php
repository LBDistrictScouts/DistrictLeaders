<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Section $section
 * @var mixed $scoutGroups
 * @var mixed $sectionTypes
 */

$this->extend('../layout/CRUD/edit');

$this->assign('entity', 'Sections');
?>
<?= $this->Form->create($section) ?>
<fieldset>
    <?php
        $args = [
            'CHANGE',
            $section->getSource(),
            null,
            null,
        ];

        $args[4] = $section::FIELD_ID;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($section::FIELD_ID) : '';

        $args[4] = $section::FIELD_SECTION;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($section::FIELD_SECTION) : '';

        $args[4] = $section::FIELD_SECTION_TYPE_ID;
        /** @var array $sectionTypes The Section Type Id List */
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($section::FIELD_SECTION_TYPE_ID, ['options' => $sectionTypes]) : '';

        $args[4] = $section::FIELD_SCOUT_GROUP_ID;
        /** @var array $scoutGroups The Scout Group Id List */
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($section::FIELD_SCOUT_GROUP_ID, ['options' => $scoutGroups]) : '';

        $args[4] = $section::FIELD_MEETING_DAY;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($section::FIELD_MEETING_DAY, [
        'options' => $section->dayList(),
        'type' => 'select',
        ]) : '';

        $args[4] = $section::FIELD_MEETING_START_TIME;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($section::FIELD_MEETING_START_TIME, [
        'options' => $section->timeList(),
        'type' => 'select',
        ]) : '';

        $args[4] = $section::FIELD_MEETING_END_TIME;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($section::FIELD_MEETING_END_TIME, [
        'options' => $section->timeList(),
        'type' => 'select',
        ]) : '';

        $args[4] = $section::FIELD_PUBLIC;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($section::FIELD_PUBLIC) : '';

        ?>
</fieldset>

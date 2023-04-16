<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\Cache\Cache;
use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * Section Entity
 *
 * @property int $id
 * @property string $section
 * @property int $section_type_id
 * @property int $scout_group_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\SectionType $section_type
 * @property \App\Model\Entity\ScoutGroup $scout_group
 * @property \App\Model\Entity\Role[] $roles
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property string|null $uuid
 * @property bool $public
 * @property int|null $meeting_day
 * @property string|null $meeting_start_time
 * @property string|null $meeting_end_time
 * @property string $meeting_weekday
 * @property \App\Model\Entity\User[] $users
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 * @property \App\Model\Entity\Audit[] $audits
 */
class Section extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    // phpcs:ignore SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
    protected $_accessible = [
        self::FIELD_SECTION => true,
        self::FIELD_SECTION_TYPE_ID => true,
        self::FIELD_SCOUT_GROUP_ID => true,
        self::FIELD_CREATED => true,
        self::FIELD_MODIFIED => true,
        self::FIELD_SECTION_TYPE => true,
        self::FIELD_SCOUT_GROUP => true,
        self::FIELD_ROLES => true,
        self::FIELD_MEETING_DAY => true,
        self::FIELD_MEETING_START_TIME => true,
        self::FIELD_MEETING_END_TIME => true,
    ];

    /**
     * Function to get Reference Time Point
     *
     * @return \Cake\I18n\FrozenTime
     */
    private function baseTime(): FrozenTime
    {
        return FrozenTime::create(2020, 1, 6, 16, 0);
    }

    /**
     * @return string
     */
    protected function _getMeetingWeekday(): string
    {
        $dayIndex = $this->get(self::FIELD_MEETING_DAY) - 1;

        if (is_integer($dayIndex) && $dayIndex > 0 && $dayIndex <= 7) {
            return $this->baseTime()->addDays($dayIndex)->dayOfWeekName;
        }

        return 'Unknown';
    }

    /**
     * Retrieve User Capabilities
     *
     * @return array<string>
     */
    public function timeList(): array
    {
        return Cache::remember('TIME_LIST', function () {
            return $this->makeTimeList();
        });
    }

    /**
     * Retrieve User Capabilities
     *
     * @return array<string>
     */
    public function dayList(): array
    {
        return Cache::remember('DAY_LIST', function () {
            return $this->makeDayList();
        });
    }

    /**
     * function to generate time indexes at 15 minute intervals
     *
     * @return array<string>
     */
    public function makeTimeList(): array
    {
        $timeStart = $this->baseTime();
        $timeEnd = FrozenTime::create(2020, 1, 6, 23, 0);

        $timeGrid = [];
        $timePoint = $timeStart;

        while ($timePoint->lessThanOrEquals($timeEnd)) {
            $timeGrid[$timePoint->format('H:i')] = $timePoint->format('H:i');
            $timePoint = $timePoint->addMinutes(15);
        }

        return $timeGrid;
    }

    /**
     * function to generate time indexes at 15 minute intervals
     *
     * @return array<string>
     */
    public function makeDayList(): array
    {
        $dayGrid = [];
        $idx = 0;
        $timePoint = $this->baseTime();

        while ($timePoint->dayOfWeek <= 7 && $idx < 7) {
            $dayGrid[$timePoint->dayOfWeek] = $timePoint->dayOfWeekName;
            $timePoint = $timePoint->addDay();
            $idx += 1;
        }

        return $dayGrid;
    }

    /**
     * @var array<string> List of Virtual Properties
     */
    protected $_virtual = ['meeting_weekday'];

    public const FIELD_ID = 'id';
    public const FIELD_SECTION = 'section';
    public const FIELD_SECTION_TYPE_ID = 'section_type_id';
    public const FIELD_SCOUT_GROUP_ID = 'scout_group_id';
    public const FIELD_CREATED = 'created';
    public const FIELD_MODIFIED = 'modified';
    public const FIELD_SECTION_TYPE = 'section_type';
    public const FIELD_SCOUT_GROUP = 'scout_group';
    public const FIELD_ROLES = 'roles';
    public const FIELD_DELETED = 'deleted';
    public const FIELD_UUID = 'uuid';
    public const FIELD_PUBLIC = 'public';
    public const FIELD_MEETING_DAY = 'meeting_day';
    public const FIELD_MEETING_START_TIME = 'meeting_start_time';
    public const FIELD_MEETING_END_TIME = 'meeting_end_time';
    public const FIELD_MEETING_WEEKDAY = 'meeting_weekday';
    public const FIELD_USERS = 'users';
    public const FIELD_AUDITS = 'audits';
}

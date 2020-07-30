<?php
declare(strict_types=1);

namespace App\Cron;

use Cake\Core\Configure;
use Cake\I18n\FrozenTime;
use Cake\ORM\Locator\LocatorAwareTrait;

/**
 * Class Cron
 *
 * @package App\Cron
 */
class Cron
{
    use LocatorAwareTrait;

    /**
     * @var \App\Model\Table\QueuedJobsTable
     */
    protected $QueuedJobs;

    /**
     * @var string
     */
    public $taskName;

    /**
     * @var array
     */
    public $dailySchedule;

    /**
     * @var array The Default Configuration
     */
    protected $defaultConfig = [
        self::CONF_DAILY_SCHEDULE => [
            self::STANDARD_JOB_TIME, // 01:00
        ], // Array
        self::CONF_TASK_NAME => '', // String
    ];

    /**
     * Setup Function
     *
     * @return void
     */
    public function __construct()
    {
        $this->QueuedJobs = $this->getTableLocator()->get('Queue.QueuedJobs');

        $className = static::class;
        $className = array_reverse(explode('\\', $className))[0];
        $config = Configure::read(self::CONF_KEY . '.' . $className);

        $this->taskName = $config[self::CONF_TASK_NAME] ?? $this->defaultConfig[self::CONF_TASK_NAME];

        $this->dailySchedule = $config[self::CONF_DAILY_SCHEDULE] ?? $this->defaultConfig[self::CONF_DAILY_SCHEDULE];
    }

    /**
     * Function to schedule configured Jobs
     *
     * @return int|false
     */
    public function scheduleJobs()
    {
        if (is_null($this->dailySchedule)) {
            return false;
        }

        $count = 0;

        foreach ($this->dailySchedule as $job) {
            if ($this->scheduleJob($job)) {
                $count += 1;
            }
        }

        return $count;
    }

    /**
     * Function to create individual Job Schedule
     *
     * @param string $offset Time Offset Compatible with FrozenTime Modify
     * @param array|null $data Data for Task
     * @return bool
     */
    protected function scheduleJob($offset, $data = null)
    {
        // If empty task will be created
        if (is_null($this->taskName) || empty($this->taskName)) {
            return false;
        }

        // Schedule Queued Job
        $job = $this->QueuedJobs->createJob(
            $this->taskName,
            $data,
            [
                'notBefore' => $this->getTimeOffset($offset),
            ]
        );

        return (bool)($job instanceof \Queue\Model\Entity\QueuedJob);
    }

    /**
     * @param string $offset Time Offset Compatible with FrozenTime Modify
     * @return \Cake\I18n\FrozenTime
     */
    protected function getTimeOffset($offset)
    {
        $now = FrozenTime::today();
        $now = $now->subSeconds($now->secondsSinceMidnight());

        return $now->modify($offset);
    }

    /**
     * Cron Method to collect all derived classes
     *
     * @return array
     */
    public static function collectCronClasses()
    {
        $tasks = Configure::read(Cron::CONF_KEY);
        $cronClasses = [];

        foreach ($tasks as $class => $task) {
            $class = '\App\Cron\\' . $class;
            array_push($cronClasses, $class);
        }

        return $cronClasses;
    }

    public const CONF_KEY = 'dailyCrons';

    public const CONF_DAILY_SCHEDULE = 'daily_schedule';
    public const CONF_TASK_NAME = 'task_name';

    public const STANDARD_JOB_TIME = '+1 hour';
}

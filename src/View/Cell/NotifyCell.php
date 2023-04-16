<?php
declare(strict_types=1);

namespace App\View\Cell;

use App\Model\Entity\Notification;
use Cake\View\Cell;

/**
 * Notify cell
 *
 * @property \App\Model\Table\NotificationsTable $Notifications
 */
class NotifyCell extends Cell
{
    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected array $_validCellOptions = [];

    /**
     * @var array<string>  Helper Array
     */
    public array $helpers = [
        'Html',
        'Time',
    ];

    /**
     * Initialization logic run at the end of object construction.
     *
     * @return void
     */
    public function initialize(): void
    {
        $this->loadModel('Notifications');
    }

    /**
     * Default display method.
     *
     * @param int $loggedInUserId The Id of the Authenticated User
     * @return void
     */
    public function display(int $loggedInUserId): void
    {
        if (is_integer($loggedInUserId)) {
            $notificationCount = $this->Notifications
                ->find('unread')
                ->contain('NotificationTypes')
                ->where([Notification::FIELD_USER_ID => $loggedInUserId])
                ->count();

            $this->set(compact('notificationCount', 'loggedInUserId'));
        }
    }
}

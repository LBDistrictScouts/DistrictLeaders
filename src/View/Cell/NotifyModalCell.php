<?php
declare(strict_types=1);

namespace App\View\Cell;

use App\Model\Entity\Notification;
use App\Model\Table\NotificationsTable;
use App\View\Helper\CapIdentityHelper;
use Cake\View\Cell;
use Cake\View\Helper\HtmlHelper;
use Cake\View\Helper\TimeHelper;

/**
 * Notify cell
 *
 * @property NotificationsTable $Notifications
 * @property HtmlHelper $Html
 * @property TimeHelper $Time
 * @property CapIdentityHelper $Identity
 */
class NotifyModalCell extends Cell
{
    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * @var string[] Helper Array
     */
    public $helpers = [
        'Html',
        'Time',
        'Identity',
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
    public function display($loggedInUserId)
    {
        if (is_integer($loggedInUserId)) {
            $notifications = $this->Notifications->find('unread', ['contain' => 'NotificationTypes'])
                ->where([Notification::FIELD_USER_ID => $loggedInUserId])
                ->limit(5)
                ->orderDesc(Notification::FIELD_CREATED);

            $this->set(compact('notifications', 'loggedInUserId'));
        }
    }
}

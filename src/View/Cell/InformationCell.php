<?php
declare(strict_types=1);

namespace App\View\Cell;

use App\Model\Entity\Notification;
use Cake\Core\Configure;
use Cake\View\Cell;

/**
 * Information cell
 */
class InformationCell extends Cell
{
    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    protected $interfacePath = 'cell/information/interface';

    protected $emailPath = 'cell/information/email';

    /**
     * Initialization logic run at the end of object construction.
     *
     * @return void
     */
    public function initialize(): void
    {
    }

    /**
     * Default display method.
     *
     * @param \App\Model\Entity\Notification $notification Notification for Display
     * @return void
     */
    public function sharedDisplay(Notification $notification)
    {
        $this->viewBuilder()->setTemplate($notification->notification_type->content_template);
        $this->set('system', Configure::read('App.who.system', 'District Leader System'));

        $this->set($notification->body_content);
    }

    /**
     * Interface display method.
     *
     * @param \App\Model\Entity\Notification $notification Notification for Interface Display
     * @return void
     */
    public function display(Notification $notification)
    {
        $this->viewBuilder()->setTemplatePath($this->interfacePath);
        $this->sharedDisplay($notification);
    }

    /**
     * Email display method.
     *
     * @param \App\Model\Entity\Notification $notification Notification for Email Display
     * @return void
     */
    public function email(Notification $notification)
    {
        $this->viewBuilder()->setTemplatePath($this->emailPath);
        $this->sharedDisplay($notification);
    }
}

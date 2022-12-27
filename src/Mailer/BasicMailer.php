<?php
declare(strict_types=1);

namespace App\Mailer;

use App\Model\Entity\EmailSend;
use App\Model\Entity\Notification;
use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\Mailer\Mailer;

/**
 * Class BasicMailer
 *
 * @package App\Mailer
 */
class BasicMailer extends Mailer
{
    /**
     * @param EmailSend $emailSend The Email Send Entity
     * @param string|null $token The Encoded Token to be sent.
     * @param EntityInterface|null $entity The Subject Entity
     * @param Notification|null $notification The Notification Entity
     * @return void
     */
    public function doSend(
        EmailSend $emailSend,
        ?string $token = null,
        ?EntityInterface $entity = null,
        ?Notification $notification = null
    ): void {
        $this
            ->setTo($emailSend->user->email, $emailSend->user->full_name)
            ->setTransport('default')
            ->setEmailFormat('both')
            ->setSender(Configure::readOrFail('App.who.email'), Configure::readOrFail('App.who.system'))
            ->addHeaders([
                'X-Email-Gen-Code' => $emailSend->email_generation_code,
                'X-Gen-ID' => $emailSend->id,
            ])
            ->setSubject($emailSend->subject);

        $this->viewBuilder()
//            ->setClassName('Email')
            ->setLayout('default')
            ->setHelpers(['Html', 'Text', 'Time'])
            ->setTemplate($emailSend->email_template);

        $viewVars = [
            'emailSend' => $emailSend,
        ];

        if (isset($token) && !is_null($token)) {
            $viewVars = array_merge($viewVars, ['token' => $token]);
        }

        if (isset($entity) && !is_null($entity)) {
            $viewVars = array_merge($viewVars, ['entity' => $entity]);
        }

        if (isset($notification) && !is_null($notification)) {
            $viewVars = array_merge($viewVars, ['notification' => $notification]);
        }

        $this->setViewVars($viewVars);
    }
}

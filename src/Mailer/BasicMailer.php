<?php
declare(strict_types=1);

namespace App\Mailer;

use App\Model\Entity\EmailSend;
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
     * @param \App\Model\Entity\EmailSend $emailSend The Email Send Entity
     * @param string|null $token The Encoded Token to be sent.
     * @param \Cake\Datasource\EntityInterface|null $entity The Subject Entity
     * @return void
     */
    public function doSend(EmailSend $emailSend, ?string $token = null, ?EntityInterface $entity = null)
    {
        $this
//            ->setTo($emailSend->user->email, $emailSend->user->full_name)
            ->setTo('jacob@lbdscouts.org.uk', $emailSend->user->full_name)
            ->setTransport('default')
            ->setEmailFormat('both')
            ->setSender(Configure::readOrFail('App.who.email'), Configure::readOrFail('App.who.system'))
            ->addHeaders([
                'X-Email-Gen-Code' => $emailSend->email_generation_code,
                'X-Gen-ID' => $emailSend->id,
            ])
            ->setSubject($emailSend->subject);

        $this->viewBuilder()
            ->setClassName('Email')
            ->setLayout('default')
            ->setHelpers(['Html', 'Text', 'Time'])
            ->setTemplate($emailSend->email_template);

        $viewVars = ['emailSend' => $emailSend];

        if (isset($token) && !is_null($token)) {
            $viewVars = array_merge($viewVars, ['token' => $token]);
        }

        if (isset($entity) && !is_null($entity)) {
            $viewVars = array_merge($viewVars, ['entity' => $entity]);
        }

        $this->setViewVars($viewVars);
    }
}

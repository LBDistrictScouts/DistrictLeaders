<?php
declare(strict_types=1);

// Create the file src/Mailer/Preview/UserMailPreview.php
namespace App\Mailer\Preview;

use App\Mailer\BasicMailer;
use App\Model\Entity\Token;
use App\Model\Table\EmailSendsTable;
use App\Model\Table\TokensTable;
use DebugKit\Mailer\MailPreview;

/**
 * Class BasicMailPreview
 *
 * @package App\Mailer\Preview
 * @property EmailSendsTable $EmailSends
 * @property TokensTable $Tokens
 */
class BasicMailPreview extends MailPreview
{
    /**
     * Password Reset Preview Mailer
     *
     * @return mixed
     */
    public function confirmation()
    {
        $this->loadModel('EmailSends');
        $this->loadModel('Tokens');

        /** @var Token $token */
        $token = $this->Tokens->find()->contain(['EmailSends' => ['Users', 'Tokens', 'Notifications']])->first();
        $emailSend = $token->email_send;
        $notification = $token->email_send->notification;
        $user = $token->email_send->user;

        /** @var BasicMailer $mailer */
        $mailer = $this->getMailer('Basic');

        $mailer->doSend($emailSend, $token->token, $user, $notification);
    }
}

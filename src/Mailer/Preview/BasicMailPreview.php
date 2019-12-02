<?php
// Create the file src/Mailer/Preview/UserMailPreview.php
namespace App\Mailer\Preview;

use DebugKit\Mailer\MailPreview;

/**
 * Class BasicMailPreview
 *
 * @package App\Mailer\Preview
 *
 * @property \App\Model\Table\EmailSendsTable $EmailSends
 * @property \App\Model\Table\TokensTable $Tokens
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

        /** @var \App\Model\Entity\Token $token */
        $token = $this->Tokens->find()->contain(['EmailSends' => ['Users', 'Tokens', 'Notifications']])->first();

        /** @var \App\Mailer\BasicMailer $mailer */
        $mailer = $this->getMailer('Basic');

        $mailer->doSend($token->email_send, $token);
    }
}

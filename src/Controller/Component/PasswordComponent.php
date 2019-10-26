<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

/**
 * Password component
 *
 * @property \App\Model\Table\EmailSendsTable $EmailSends
 * @property \Cake\Controller\Component\FlashComponent $Flash
 */
class PasswordComponent extends Component
{
    public $components = ['Flash'];

    /**
     * Generate a Password Reset Token and Dispatch the Email.
     *
     * @param int $userId The User ID to be Reset.
     *
     * @return bool
     */
    public function sendReset($userId)
    {
        $this->EmailSends = TableRegistry::getTableLocator()->get('EmailSends');
        $sendCode = 'USR-' . $userId . '-PWD';

        return $this->EmailSends->makeAndSend($sendCode);
    }
}

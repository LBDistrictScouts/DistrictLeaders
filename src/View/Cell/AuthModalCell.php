<?php
declare(strict_types=1);

namespace App\View\Cell;

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\View\Cell;

/**
 * AuthModal cell
 */
class AuthModalCell extends Cell
{
    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * Initialization logic run at the end of object construction.
     *
     * @return void
     */
    public function initialize(): void
    {
    }

    /**
     * @param int $reason The Reason ID
     * @return bool|string
     */
    protected function getReasonLong(int $reason)
    {
        Configure::load('Application' . DS . 'reasons', 'yaml');
        $reasons = Configure::read('Reasons', []);

        if (key_exists($reason, $reasons)) {
            return $reasons[$reason];
        }

        return false;
    }

    /**
     * @param int $reason Reason ID for Display
     * @return mixed
     */
    protected function getCachedReasonLong(int $reason)
    {
        return Cache::remember('reason-key-' . $reason, function () use ($reason) {
            return $this->getReasonLong($reason);
        });
    }

    /**
     * Default display method.
     *
     * @param \Authorization\Policy\Result $policyResult The result of the Policy Authorisation
     * @param \Authorization\IdentityInterface $identity The User
     * @return void
     */
    public function display($policyResult, $identity)
    {
        $reason = $policyResult->getReason();

        if (is_numeric($reason)) {
            $reason = (int)$reason;
            $reason = $this->getCachedReasonLong($reason);
        }

        $this->set('reason', $reason);
        $this->set('status', $policyResult->getStatus());
    }
}

<?php
namespace App\Policy;

use Authorization\Policy\RequestPolicyInterface;
use Cake\Http\ServerRequest;

/**
 * Class RequestPolicy
 *
 * @package App\Policy
 */
class RequestPolicy implements RequestPolicyInterface
{
    /**
     * Method to check if the request can be accessed
     *
     * @param \App\Model\Entity\User|null $identity The Identity
     * @param \Cake\Http\ServerRequest $request Server Request
     *
     * @return bool|void
     */
    public function canAccess($identity, ServerRequest $request)
    {
        // Prevent DebugKit from infinitely looping
        if (($request->getParam('plugin') === 'DebugKit')) {
            return true;
        }

        if (!is_null($identity) && $identity->checkCapability('ALL')) {
            return true;
        }

        // Baseline Access
        if ($request->getParam('controller') === 'Pages') {
            if ($request->getParam('action') === 'display') {
                return true;
            }
        }

        if ($request->getParam('controller') === 'Users') {
            if (in_array($request->getParam('action'), ['login', 'logout'])) {
                return true;
            }
        }

        return false;
    }
}

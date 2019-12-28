<?php
declare(strict_types=1);

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
        if ($request->getParam('plugin') === 'DebugKit') {
            return true;
        }

        if (!is_null($identity) && $identity->checkCapability('ALL')) {
            return true;
        }

        // Baseline Access
        if ($request->getParam('controller') === 'Pages' && $request->getParam('action') === 'display') {
            return true;
        }

        // Token Validation
        if ($request->getParam('controller') === 'Tokens' && $request->getParam('action') === 'validate') {
            return true;
        }

        // User controller allow
        $userActions = ['login', 'logout', 'username', 'token', 'password', 'forgot'];
        if ($request->getParam('controller') === 'Users' && in_array($request->getParam('action'), $userActions)) {
            return true;
        }

        return false;
    }
}

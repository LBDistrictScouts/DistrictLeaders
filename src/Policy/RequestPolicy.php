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
     * @return bool
     */
    public function canAccess($identity, ServerRequest $request)
    {
        // Prevent DebugKit from infinitely looping
        if (($request->getParam('plugin') === 'DebugKit')) {
            return true;
        }
//        $userCapabilities = $identity->capabilities['user'];
//        if (is_array($userCapabilities) && in_array('LOGIN', $userCapabilities)) {

        // Baseline Access
        if ($request->getParam('controller') === 'Pages') {
            if ($request->getParam('action') === 'display') {
                return true;
            }
        }

        if ($request->getParam('controller') === 'Users') {
            if (in_array($request->getParam('action'), ['login'])) {
                return true;
            }
        }

        return true;
    }
}

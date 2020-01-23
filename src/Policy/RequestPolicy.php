<?php
declare(strict_types=1);

namespace App\Policy;

use Authorization\Policy\RequestPolicyInterface;
use Authorization\Policy\Result;
use Cake\Http\ServerRequest;
use Cake\Log\Log;

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
     * @return bool|void|\Authorization\Policy\Result
     */
    public function canAccess($identity, ServerRequest $request)
    {
        // Prevent DebugKit from infinitely looping
        if ($request->getParam('plugin') === 'DebugKit') {
            return new Result(true);
        }

        if (!is_null($identity) && $identity->checkCapability('ALL')) {
            return new Result(true);
        }

        // Baseline Access
        if ($request->getParam('controller') === 'Pages' && $request->getParam('action') === 'display') {
            return new Result(true);
        }

        // Token Validation
        if ($request->getParam('controller') === 'Tokens' && $request->getParam('action') === 'validate') {
            return new Result(true);
        }

        // Own User Validation
        Log::debug($request->getParam('action'));
        if (
            $request->getParam('controller') === 'Users'
            && in_array($request->getParam('action'), ['edit', 'view', 'password'])
        ) {
            $object = explode('/', $request->getPath());
            $object = array_reverse($object)[0];

            if ($identity->id == $object && $identity->checkCapability('OWN_USER')) {
                return new Result(true);
            }
        }

        // User controller allow
        $userActions = ['login', 'logout', 'username', 'token', 'password', 'forgot'];
        if ($request->getParam('controller') === 'Users' && in_array($request->getParam('action'), $userActions)) {
            return new Result(true);
        }

        if ($identity->buildAndCheckCapability($request->getParam('action'), $request->getParam('controller'))) {
            return new Result(true);
        }
    }
}

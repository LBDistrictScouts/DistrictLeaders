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
     * @return null|\Authorization\Policy\Result
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function canAccess($identity, ServerRequest $request): ?Result
    {
        $action = $request->getParam('action');
        $controller = $request->getParam('controller');

        // Prevent DebugKit from infinitely looping
        if ($request->getParam('plugin') === 'DebugKit') {
            return new Result(true);
        }

        if (!is_null($identity) && $identity->checkCapability('ALL')) {
            return new Result(true);
        }

        // Baseline Access
        if ($controller === 'Pages' && $action === 'display') {
            return new Result(true);
        }

        // Token Validation
        if ($controller === 'Tokens' && $action === 'validate') {
            return new Result(true);
        }

        // Own User Validation
        Log::debug($action);
        if ($controller === 'Users' && in_array($action, ['edit', 'view', 'password'])) {
            $object = explode('/', $request->getPath());
            $object = array_reverse($object)[0];

            if ($identity->id == $object && $identity->checkCapability('OWN_USER')) {
                return new Result(true);
            }
        }

        // User controller allow
        $userActions = ['login', 'logout', 'username', 'token', 'password', 'forgot'];
        if ($controller === 'Users' && in_array($action, $userActions)) {
            return new Result(true);
        }

        if (!is_null($identity) && isset($identity)) {
            if ($identity->buildAndCheckCapability($action, $request->getParam('controller'))) {
                return new Result(true);
            }
        }

        return null;
    }
}

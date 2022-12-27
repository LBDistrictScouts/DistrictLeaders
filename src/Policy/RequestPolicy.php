<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\User;
use Authorization\Policy\RequestPolicyInterface;
use Authorization\Policy\Result;
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
     * @param User|null $identity The Identity
     * @param ServerRequest $request Server Request
     * @return null|Result
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function canAccess($identity, ServerRequest $request): ?Result
    {
        $action = $request->getParam('action');
        $controller = $request->getParam('controller');
        $prefix = $request->getParam('prefix');

        if ($prefix === 'Api/V1') {
            return new Result(true);
        }

        if ($controller === 'Challenges') {
            return new Result(true);
        }

        // Prevent DebugKit from infinitely looping
        if (in_array($request->getParam('plugin'), ['DebugKit', 'TestHelper'])) {
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
        $object = explode('/', $request->getPath());
        $object = array_reverse($object)[0];

        if ($controller === 'Users' && in_array($action, ['edit', 'view'])) {
            if ($identity->id == $object && $identity->checkCapability('OWN_USER')) {
                return new Result(true);
            }
        }

        if ($controller === 'Capabilities' && in_array($action, ['permissions'])) {
            if ($identity->id == $object && $identity->checkCapability('OWN_USER')) {
                return new Result(true);
            }
        }

        // User controller allow
        $userActions = ['login', 'logout', 'username', 'token', 'password', 'forgot', 'welcome'];
        if ($controller === 'Users' && in_array($action, $userActions)) {
            return new Result(true);
        }

        if (isset($identity) && !is_null($identity) && $identity->buildAndCheckCapability($action, $controller)) {
            return new Result(true, 'Entity Specific Capability Present.');
        }

        // Webroot
        $path = $request->getPath();
        $webrootPaths = [
            '/apple-touch-icon-precomposed.png',
        ];
        if (in_array($path, $webrootPaths)) {
            return new Result(true, 'Webroot Access for Icons etc');
        }

        return new Result(false, 'No Authorisation Rules');
    }
}

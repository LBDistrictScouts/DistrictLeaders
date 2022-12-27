<?php

declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Controller\Component\CapAuthorizationComponent;
use Authentication\Controller\Component\AuthenticationComponent;
use Cake\Controller\Controller;
use Exception;
use Flash\Controller\Component\FlashComponent;

/**
 * App Controller
 *
 * @property AuthenticationComponent $Authentication
 * @property FlashComponent $Flash
 * @property CapAuthorizationComponent $Authorization.Authorization
 */
class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     * @throws Exception
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Authentication.Authentication');
        $this->loadComponent('Authorization.Authorization', ['className' => 'CapAuthorization']);

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);

        $this->Authentication->allowUnauthenticated(['index']);
        $this->Authentication->addUnauthenticatedActions(['index']);
        $this->Authorization->skipAuthorization();
    }
}

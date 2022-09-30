<?php
declare(strict_types=1);

namespace App\Controller\Api\V1;

use Cake\Controller\Controller;

/**
 * App Controller
 *
 * @property \Authentication\Controller\Component\AuthenticationComponent $Authentication
 * @property \Flash\Controller\Component\FlashComponent $Flash
 * @property \App\Controller\Component\CapAuthorizationComponent $Authorization.Authorization
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
     * @throws \Exception
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

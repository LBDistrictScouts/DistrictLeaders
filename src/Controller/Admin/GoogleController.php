<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Form\GoogleAuthForm;

/**
 * Google Controller
 *
 * @property \App\Controller\Component\GoogleClientComponent GoogleClient
 * @property \Cake\ORM\Table $Google
 */
class GoogleController extends AppController
{
    /**
     * @throws \Exception
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('GoogleClient');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $domain = $this->request->getQuery('domain');

        $googleUsers = $this->GoogleClient->getList($domain);
        $domains = $this->GoogleClient->getDomainList();

        $domainList = [];

        /** @var \Google_Service_Directory_Domains $domain */
        foreach ($domains->getDomains() as $domain) {
            $domainName = $domain->getDomainName();
            $urlDomain = urlencode($domainName);
            $domainList[$urlDomain] = $domainName;
        }

        $this->set(compact('googleUsers', 'domainList'));
    }

    /**
     * View method
     *
     * @param null $id Google id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $google = $this->Google->get($id, [
            'contain' => [],
        ]);

        $this->set('google', $google);
    }

    /**
     * View method
     *
     * @return \Cake\Http\Response|void
     */
    public function status()
    {
    }

    /**
     * Google Integration Method method
     *
     * @throws \Exception
     * @return \Cake\Http\Response|void
     */
    public function auth()
    {
        $client = $this->GoogleClient->newClient();
        $form = new GoogleAuthForm();

        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, and is
        // created automatically when the authorization flow completes for the first
        // time.
        $client = $this->GoogleClient->getToken($client);

        // Get state of url
        if ($this->request->is('get')) {
            // If there is no previous token or it's expired.
            if (!$client->isAccessTokenExpired()) {
                $this->Flash->success('Token is Active');

                return $this->redirect(['prefix' => 'Admin', 'controller' => 'Google', 'action' => 'status']);
            }

            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                $this->GoogleClient->saveToken($client);
                $this->Flash->success('Token Successfully Renewed.');

                return $this->redirect(['prefix' => 'Admin', 'controller' => 'Google', 'action' => 'status']);
            } else {
                // Request authorization from the user.
                $authUrl = $client->createAuthUrl();
                $this->set(compact('authUrl', 'form'));
            }
        }

        // Post the Authorisation Response
        if ($this->request->is('post')) {
            // Exchange authorization code for an access token.
            $accessToken = $client->fetchAccessTokenWithAuthCode($this->request->getData('auth_code'));
            $client->setAccessToken($accessToken);

            // Check to see if there was an error.
            if (array_key_exists('error', $accessToken)) {
                $this->log(join(', ', $accessToken), 'error');
                $this->Flash->error('Error in Authorising Token.');

                return $this->redirect(['prefix' => 'Admin', 'controller' => 'Google', 'action' => 'status']);
            }
            $this->Flash->success('Token Authorised Successfully.');
            $this->GoogleClient->saveToken($client);

            return $this->redirect(['prefix' => 'Admin', 'controller' => 'Google', 'action' => 'status']);
        }
    }
}

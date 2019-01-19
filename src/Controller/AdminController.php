<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Form\GoogleAuthForm;
use Cake\Core\Configure;

/**
 * Admin Controller
 *
 * @property \App\Controller\Component\GoogleClientComponent GoogleClient
 */
class AdminController extends AppController
{
    /**
     * Status Method
     *
     * @return void
     */
    public function status()
    {
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function logs()
    {
        $admin = $this->paginate($this->Admin);

        $this->set(compact('admin'));
    }

    /**
     * Google Integration Method method
     *
     * @throws \Exception
     *
     * @return \Cake\Http\Response
     */
    public function google()
    {
        $this->loadComponent('GoogleClient');

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

                return $this->redirect(['controller' => 'Admin', 'action' => 'status']);
            }

            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                $this->GoogleClient->saveToken($client);
                $this->Flash->success('Token Successfully Renewed.');

                return $this->redirect(['controller' => 'Admin', 'action' => 'status']);
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

                return $this->redirect(['controller' => 'Admin', 'action' => 'google']);
            }
            $this->Flash->success('Token Authorised Successfully.');
            $this->GoogleClient->saveToken($client);

            return $this->redirect(['controller' => 'Admin', 'action' => 'status']);
        }
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $admin = $this->Admin->newEntity();
        if ($this->request->is('post')) {
            $admin = $this->Admin->patchEntity($admin, $this->request->getData());
            if ($this->Admin->save($admin)) {
                $this->Flash->success(__('The admin has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The admin could not be saved. Please, try again.'));
        }
        $this->set(compact('admin'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Admin id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $admin = $this->Admin->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $admin = $this->Admin->patchEntity($admin, $this->request->getData());
            if ($this->Admin->save($admin)) {
                $this->Flash->success(__('The admin has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The admin could not be saved. Please, try again.'));
        }
        $this->set(compact('admin'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Admin id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $admin = $this->Admin->get($id);
        if ($this->Admin->delete($admin)) {
            $this->Flash->success(__('The admin has been deleted.'));
        } else {
            $this->Flash->error(__('The admin could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

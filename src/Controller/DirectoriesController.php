<?php
declare(strict_types=1);

namespace App\Controller;

use App\Form\GoogleAuthForm;
use App\Model\Entity\Directory;

/**
 * Directories Controller
 *
 * @property \App\Model\Table\DirectoriesTable $Directories
 * @property \App\Controller\Component\GoogleClientComponent $GoogleClient
 * @property \App\Controller\Component\QueueComponent $Queue
 * @method \App\Model\Entity\Directory[]|\App\Controller\ResultSetInterface paginate($object = null, array $settings = [])
 */

class DirectoriesController extends AppController
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
    public function index(): ?Response
    {
        $this->paginate = [
            'contain' => ['DirectoryTypes'],
        ];
        $directories = $this->paginate($this->Directories);

        $this->set(compact('directories'));
    }

    /**
     * View method
     *
     * @param null $directoryID Directory id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(null $directoryID = null): ?Response
    {
        $directory = $this->Directories->get($directoryID, [
            'contain' => ['DirectoryTypes', 'DirectoryDomains', 'DirectoryGroups', 'DirectoryUsers.UserContacts'],
        ]);

        $this->set('directory', $directory);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add(): ?Response
    {
        $directory = $this->Directories->newEmptyEntity();
        if ($this->request->is('post')) {
            $directory = $this->Directories->patchEntity($directory, $this->request->getData());
            if ($this->Directories->save($directory)) {
                $this->Flash->success(__('The directory has been saved.'));

                return $this->redirect(['action' => 'view', $directory->get(Directory::FIELD_ID)]);
            }
            $this->Flash->error(__('The directory could not be saved. Please, try again.'));
        }
        $directoryTypes = $this->Directories->DirectoryTypes->find('list', ['limit' => 200]);
        $this->set(compact('directory', 'directoryTypes'));
    }

    /**
     * Edit method
     *
     * @param string|null $directoryID Directory id.
     * @return \Cake\Http\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $directoryID = null): ?Response
    {
        $directory = $this->Directories->get($directoryID, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $directory = $this->Directories->patchEntity($directory, $this->request->getData());
            if ($this->Directories->save($directory)) {
                $this->Flash->success(__('The directory has been saved.'));

                return $this->redirect(['action' => 'view', $directory->get(Directory::FIELD_ID)]);
            }
            $this->Flash->error(__('The directory could not be saved. Please, try again.'));
        }
        $directoryTypes = $this->Directories->DirectoryTypes->find('list', ['limit' => 200]);
        $this->set(compact('directory', 'directoryTypes'));
    }

    /**
     * Edit method
     *
     * @param string|null $directoryID Directory id.
     * @return \Cake\Http\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     * @throws \Google_Exception
     */
    public function auth(?string $directoryID = null): ?Response
    {
        $directory = $this->Directories->get($directoryID, [
            'contain' => [],
        ]);
        $form = new GoogleAuthForm();

        $client = $this->GoogleClient->newClient();

        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, and is
        // created automatically when the authorization flow completes for the first
        // time.
        $client = $this->GoogleClient->getToken($client, $directory);

        // Get state of url
        if ($this->request->is('get')) {
            // If there is no previous token or it's expired.
            if (!$client->isAccessTokenExpired()) {
                $this->Flash->success('Token is Active');

                return $this->redirect(['action' => 'view', $directoryID]);
            }

            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                $this->GoogleClient->saveToken($client, $directory);
                $this->Flash->success('Token Successfully Renewed.');

                return $this->redirect(['action' => 'view', $directoryID]);
            } else {
                $directory->set(Directory::FIELD_ACTIVE, false);
                $this->Directories->save($directory);

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

                return $this->redirect(['action' => 'view', $directoryID]);
            }
            $this->Flash->success('Token Authorised Successfully.');
            $this->GoogleClient->saveToken($client, $directory);

            return $this->redirect(['action' => 'view', $directoryID]);
        }
    }

    /**
     * @return \Cake\Http\Response
     * @throws \Google_Exception
     */
    public function response(): Response
    {
        $responseParams = $this->getRequest()->getQueryParams();

        if (key_exists('code', $responseParams)) {
            $query = $this->Directories->find()->where([Directory::FIELD_ACTIVE => false]);

            if ($query->count() == 1) {
                /** @var \App\Model\Entity\Directory $directory */
                $directory = $query->firstOrFail();

                $client = $this->GoogleClient->newClient();
                $accessToken = $client->fetchAccessTokenWithAuthCode($responseParams['code']);
                $client->setAccessToken($accessToken);

                // Check to see if there was an error.
                if (array_key_exists('error', $accessToken)) {
                    $this->log(join(', ', $accessToken), 'error');
                    $this->Flash->error('Error in Authorising Token.');

                    return $this->redirect(['action' => 'view', $directory->id]);
                }
                $this->Flash->success('Token Authorised Successfully.');
                $this->GoogleClient->saveToken($client, $directory);

                $directory->set(Directory::FIELD_ACTIVE, true);
                $this->Directories->save($directory);

                return $this->redirect(['action' => 'view', $directory->id]);
            }
        }

        $this->Flash->error('Code unprocessed. Token not Authorised.');

        return $this->redirect('/');
    }

    /**
     * Delete method
     *
     * @param string|null $directoryID Directory id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $directoryID = null): ?Response
    {
        $this->request->allowMethod(['post', 'delete']);
        $directory = $this->Directories->get($directoryID);
        if ($this->Directories->delete($directory)) {
            $this->Flash->success(__('The directory has been deleted.'));
        } else {
            $this->Flash->error(__('The directory could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Delete method
     *
     * @param string|null $directoryId Directory id.
     * @return \Cake\Http\Response|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function populate(?string $directoryId = null): ?Response
    {
        $this->request->allowMethod(['post']);
        $directory = $this->Directories->get($directoryId);

        $this->loadComponent('Queue');
        $this->Queue->setDirectoryImport($directory);

        return $this->redirect(['controller' => 'Directories', 'action' => 'view', $directoryId]);
    }
}

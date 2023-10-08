<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;

/**
 * Capabilities Controller
 *
 * @property \App\Model\Table\CapabilitiesTable $Capabilities
 * @property \App\Controller\Component\QueueComponent $Queue
 * @method \App\Model\Entity\Capability[]|\App\Controller\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CapabilitiesController extends AppController
{
    /**
     * @throws \Exception
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->Authorization->mapActions([
            'permissions' => 'viewPermissions',
        ]);

        $this->whyPermitted($this->Capabilities);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index(): void
    {
        $capabilities = $this->paginate($this->Capabilities);

        $this->set(compact('capabilities'));
    }

    /**
     * View method
     *
     * @param int|null $capabilityId Capability id.
     * @return void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?int $capabilityId = null): void
    {
        $capability = $this->Capabilities->get($capabilityId, [
            'contain' => ['RoleTypes'],
        ]);

        $this->set('capability', $capability);
    }

    /**
     * View method
     *
     * @param int|null $userId User id.
     * @return void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function permissions(?int $userId = null): void
    {
        $user = $this->Capabilities->RoleTypes->Roles->Users->get($userId);
        $this->set('user', $user);

        $capabilities = $this->Capabilities->enrichUserCapability($user->capabilities);

        foreach ($capabilities as $key => $array) {
            if (strstr($key, '.')) {
                $keyArray = explode('.', $key);
                if (strstr($key, 'Group')) {
                    $group = $this->Capabilities->RoleTypes->Roles->Sections->ScoutGroups->get($keyArray[1]);
                    $capabilities[$key]['object'] = $group;
                }
                if (strstr($key, 'Section')) {
                    $section = $this->Capabilities->RoleTypes->Roles->Sections->get($keyArray[1]);
                    $capabilities[$key]['object'] = $section;
                }
            }
        }
        $this->set('capabilities', $capabilities);

        $models = Configure::read('AllModels');
        ksort($models);
        $this->set('models', $models);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add(): void
    {
        $capability = $this->Capabilities->newEmptyEntity();
        if ($this->request->is('post')) {
            $capability = $this->Capabilities->patchEntity($capability, $this->request->getData());
            if ($this->Capabilities->save($capability)) {
                $this->Flash->success(__('The capability has been saved.'));

                $this->redirect(['action' => 'edit', $capability->get('id'), '?' => ['roleTypes' => true]]);
            }
            $this->Flash->error(__('The capability could not be saved. Please, try again.'));
        }
        $this->set(compact('capability'));
    }

    /**
     * Edit method
     *
     * @param string|null $capabilityId Capability id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $capabilityId = null): void
    {
        $capability = $this->Capabilities->get($capabilityId, [
            'contain' => ['RoleTypes'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $capability = $this->Capabilities->patchEntity($capability, $this->request->getData());
            if ($this->Capabilities->save($capability)) {
                $this->Flash->success(__('The capability has been saved.'));

                $this->redirect(['action' => 'view', $capability->get('id')]);
            }
            $this->Flash->error(__('The capability could not be saved. Please, try again.'));
        }
        $roleTypes = $this->Capabilities->RoleTypes->find('list', [
            'conditions' => [
                'level >=' => $capability->min_level,
            ],
            'keyField' => 'id',
            'valueField' => 'role_abbreviation',
//            'groupField' => 'level',
        ]);
        $this->set(compact('capability', 'roleTypes'));
    }

    /**
     * Delete method
     *
     * @param string|null $capabilityId Capability id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $capabilityId = null): void
    {
        $this->request->allowMethod(['post', 'delete']);
        $capability = $this->Capabilities->get($capabilityId);
        if ($this->Capabilities->delete($capability)) {
            $this->Flash->success(__('The capability has been deleted.'));
        } else {
            $this->Flash->error(__('The capability could not be deleted. Please, try again.'));
        }

        $this->redirect(['action' => 'index']);
    }

    /**
     * Process method
     *
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function process(): void
    {
        $this->request->allowMethod(['post']);

        $this->loadComponent('Queue');
        $this->Queue->setCapabilityParse();

        $this->redirect(['controller' => 'Admin', 'action' => 'index']);
    }
}

<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\DirectoryDomain;

/**
 * DirectoryDomains Controller
 *
 * @property \App\Model\Table\DirectoryDomainsTable $DirectoryDomains
 * @method \App\Model\Entity\DirectoryDomain[]|\App\Controller\ResultSetInterface paginate($object = null, array $settings = [])
 */

class DirectoryDomainsController extends AppController
{
    /**
     * Index method
     *
     * @return void
     */
    public function index(): void
    {
        $this->paginate = [
            'contain' => ['Directories'],
        ];
        $directoryDomains = $this->paginate($this->DirectoryDomains);

        $this->set(compact('directoryDomains'));
    }

    /**
     * View method
     *
     * @param int $id Directory Domain id.
     * @return void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(int $id): void
    {
        $directoryDomain = $this->DirectoryDomains->get($id, [
            'contain' => ['Directories'],
        ]);

        $this->set('directoryDomain', $directoryDomain);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add(): void
    {
        $directoryDomain = $this->DirectoryDomains->newEmptyEntity();
        if ($this->request->is('post')) {
            $directoryDomain = $this->DirectoryDomains->patchEntity($directoryDomain, $this->request->getData());
            if ($this->DirectoryDomains->save($directoryDomain)) {
                $this->Flash->success(__('The directory domain has been saved.'));

                $this->redirect(['action' => 'view', $directoryDomain->get(DirectoryDomain::FIELD_ID)]);
            }
            $this->Flash->error(__('The directory domain could not be saved. Please, try again.'));
        }
        $directories = $this->DirectoryDomains->Directories->find('list', ['limit' => 200]);
        $this->set(compact('directoryDomain', 'directories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Directory Domain id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null): void
    {
        $directoryDomain = $this->DirectoryDomains->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $directoryDomain = $this->DirectoryDomains->patchEntity($directoryDomain, $this->request->getData());
            if ($this->DirectoryDomains->save($directoryDomain)) {
                $this->Flash->success(__('The directory domain has been saved.'));

                $this->redirect(['action' => 'view', $directoryDomain->get(DirectoryDomain::FIELD_ID)]);
            }
            $this->Flash->error(__('The directory domain could not be saved. Please, try again.'));
        }
        $directories = $this->DirectoryDomains->Directories->find('list', ['limit' => 200]);
        $this->set(compact('directoryDomain', 'directories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Directory Domain id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null): void
    {
        $this->request->allowMethod(['post', 'delete']);
        $directoryDomain = $this->DirectoryDomains->get($id);
        if ($this->DirectoryDomains->delete($directoryDomain)) {
            $this->Flash->success(__('The directory domain has been deleted.'));
        } else {
            $this->Flash->error(__('The directory domain could not be deleted. Please, try again.'));
        }

        $this->redirect(['action' => 'index']);
    }
}

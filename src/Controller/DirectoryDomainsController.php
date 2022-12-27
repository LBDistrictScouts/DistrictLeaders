<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\DirectoryDomain;
use App\Model\Table\DirectoryDomainsTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;

/**
 * DirectoryDomains Controller
 *
 * @property DirectoryDomainsTable $DirectoryDomains
 * @method DirectoryDomain[]|ResultSetInterface paginate($object = null, array $settings = [])
 */

class DirectoryDomainsController extends AppController
{
    /**
     * Index method
     *
     * @return Response|void
     */
    public function index()
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
     * @param null $id Directory Domain id.
     * @return Response|void
     * @throws RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $directoryDomain = $this->DirectoryDomains->get($id, [
            'contain' => ['Directories'],
        ]);

        $this->set('directoryDomain', $directoryDomain);
    }

    /**
     * Add method
     *
     * @return Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $directoryDomain = $this->DirectoryDomains->newEmptyEntity();
        if ($this->request->is('post')) {
            $directoryDomain = $this->DirectoryDomains->patchEntity($directoryDomain, $this->request->getData());
            if ($this->DirectoryDomains->save($directoryDomain)) {
                $this->Flash->success(__('The directory domain has been saved.'));

                return $this->redirect(['action' => 'view', $directoryDomain->get(DirectoryDomain::FIELD_ID)]);
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
     * @return Response|void Redirects on successful edit, renders view otherwise.
     * @throws RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $directoryDomain = $this->DirectoryDomains->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $directoryDomain = $this->DirectoryDomains->patchEntity($directoryDomain, $this->request->getData());
            if ($this->DirectoryDomains->save($directoryDomain)) {
                $this->Flash->success(__('The directory domain has been saved.'));

                return $this->redirect(['action' => 'view', $directoryDomain->get(DirectoryDomain::FIELD_ID)]);
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
     * @return Response|null Redirects to index.
     * @throws RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $directoryDomain = $this->DirectoryDomains->get($id);
        if ($this->DirectoryDomains->delete($directoryDomain)) {
            $this->Flash->success(__('The directory domain has been deleted.'));
        } else {
            $this->Flash->error(__('The directory domain could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

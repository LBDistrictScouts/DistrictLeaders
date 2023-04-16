<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\DirectoryType;

/**
 * DirectoryTypes Controller
 *
 * @property \App\Model\Table\DirectoryTypesTable $DirectoryTypes
 * @method \App\Model\Entity\DirectoryType[]|\App\Controller\ResultSetInterface paginate($object = null, array $settings = [])
 */

class DirectoryTypesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index(): ?Response
    {
        $directoryTypes = $this->paginate($this->DirectoryTypes);

        $this->set(compact('directoryTypes'));
    }

    /**
     * View method
     *
     * @param null $id Directory Type id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(null $id = null): ?Response
    {
        $directoryType = $this->DirectoryTypes->get($id, [
            'contain' => ['Directories'],
        ]);

        $this->set('directoryType', $directoryType);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add(): ?Response
    {
        $directoryType = $this->DirectoryTypes->newEmptyEntity();
        if ($this->request->is('post')) {
            $directoryType = $this->DirectoryTypes->patchEntity($directoryType, $this->request->getData());
            if ($this->DirectoryTypes->save($directoryType)) {
                $this->Flash->success(__('The directory type has been saved.'));

                return $this->redirect(['action' => 'view', $directoryType->get(DirectoryType::FIELD_ID)]);
            }
            $this->Flash->error(__('The directory type could not be saved. Please, try again.'));
        }
        $this->set(compact('directoryType'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Directory Type id.
     * @return \Cake\Http\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null): ?Response
    {
        $directoryType = $this->DirectoryTypes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $directoryType = $this->DirectoryTypes->patchEntity($directoryType, $this->request->getData());
            if ($this->DirectoryTypes->save($directoryType)) {
                $this->Flash->success(__('The directory type has been saved.'));

                return $this->redirect(['action' => 'view', $directoryType->get(DirectoryType::FIELD_ID)]);
            }
            $this->Flash->error(__('The directory type could not be saved. Please, try again.'));
        }
        $this->set(compact('directoryType'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Directory Type id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null): ?Response
    {
        $this->request->allowMethod(['post', 'delete']);
        $directoryType = $this->DirectoryTypes->get($id);
        if ($this->DirectoryTypes->delete($directoryType)) {
            $this->Flash->success(__('The directory type has been deleted.'));
        } else {
            $this->Flash->error(__('The directory type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

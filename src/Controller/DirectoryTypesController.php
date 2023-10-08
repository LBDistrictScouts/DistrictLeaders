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
     * @return void
     */
    public function index(): void
    {
        $directoryTypes = $this->paginate($this->DirectoryTypes);

        $this->set(compact('directoryTypes'));
    }

    /**
     * View method
     *
     * @param int $directoryTypeId Directory Type id.
     * @return void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(int $directoryTypeId): void
    {
        $directoryType = $this->DirectoryTypes->get($directoryTypeId, [
            'contain' => ['Directories'],
        ]);

        $this->set('directoryType', $directoryType);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add(): void
    {
        $directoryType = $this->DirectoryTypes->newEmptyEntity();
        if ($this->request->is('post')) {
            $directoryType = $this->DirectoryTypes->patchEntity($directoryType, $this->request->getData());
            if ($this->DirectoryTypes->save($directoryType)) {
                $this->Flash->success(__('The directory type has been saved.'));

                $this->redirect(['action' => 'view', $directoryType->get(DirectoryType::FIELD_ID)]);
            }
            $this->Flash->error(__('The directory type could not be saved. Please, try again.'));
        }
        $this->set(compact('directoryType'));
    }

    /**
     * Edit method
     *
     * @param string|null $directoryTypeId Directory Type id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $directoryTypeId): void
    {
        $directoryType = $this->DirectoryTypes->get($directoryTypeId, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $directoryType = $this->DirectoryTypes->patchEntity($directoryType, $this->request->getData());
            if ($this->DirectoryTypes->save($directoryType)) {
                $this->Flash->success(__('The directory type has been saved.'));

                $this->redirect(['action' => 'view', $directoryType->get(DirectoryType::FIELD_ID)]);
            }
            $this->Flash->error(__('The directory type could not be saved. Please, try again.'));
        }
        $this->set(compact('directoryType'));
    }

    /**
     * Delete method
     *
     * @param string|int $directoryTypeId Directory Type id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(string $directoryTypeId): void
    {
        $this->request->allowMethod(['post', 'delete']);
        $directoryType = $this->DirectoryTypes->get($directoryTypeId);
        if ($this->DirectoryTypes->delete($directoryType)) {
            $this->Flash->success(__('The directory type has been deleted.'));
        } else {
            $this->Flash->error(__('The directory type could not be deleted. Please, try again.'));
        }

        $this->redirect(['action' => 'index']);
    }
}

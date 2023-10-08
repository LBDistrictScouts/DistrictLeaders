<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\DirectoryGroup;

/**
 * DirectoryGroups Controller
 *
 * @property \App\Model\Table\DirectoryGroupsTable $DirectoryGroups
 * @method \App\Model\Entity\DirectoryGroup[]|\App\Controller\ResultSetInterface paginate($object = null, array $settings = [])
 */

class DirectoryGroupsController extends AppController
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
        $directoryGroups = $this->paginate($this->DirectoryGroups);

        $this->set(compact('directoryGroups'));
    }

    /**
     * View method
     *
     * @param int $id Directory Group id.
     * @return void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(int $id): void
    {
        $directoryGroup = $this->DirectoryGroups->get($id, [
            'contain' => ['Directories', 'RoleTypes'],
        ]);

        $this->set('directoryGroup', $directoryGroup);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add(): void
    {
        $directoryGroup = $this->DirectoryGroups->newEmptyEntity();
        if ($this->request->is('post')) {
            $directoryGroup = $this->DirectoryGroups->patchEntity($directoryGroup, $this->request->getData());
            if ($this->DirectoryGroups->save($directoryGroup)) {
                $this->Flash->success(__('The directory group has been saved.'));

                $this->redirect(['action' => 'view', $directoryGroup->get(DirectoryGroup::FIELD_ID)]);
            }
            $this->Flash->error(__('The directory group could not be saved. Please, try again.'));
        }
        $directories = $this->DirectoryGroups->Directories->find('list', ['limit' => 200]);
        $roleTypes = $this->DirectoryGroups->RoleTypes->find('list', ['limit' => 200]);
        $this->set(compact('directoryGroup', 'directories', 'roleTypes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Directory Group id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null): void
    {
        $directoryGroup = $this->DirectoryGroups->get($id, [
            'contain' => ['RoleTypes'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $directoryGroup = $this->DirectoryGroups->patchEntity($directoryGroup, $this->request->getData());
            if ($this->DirectoryGroups->save($directoryGroup)) {
                $this->Flash->success(__('The directory group has been saved.'));

                $this->redirect(['action' => 'view', $directoryGroup->get(DirectoryGroup::FIELD_ID)]);
            }
            $this->Flash->error(__('The directory group could not be saved. Please, try again.'));
        }
        $directories = $this->DirectoryGroups->Directories->find('list', ['limit' => 200]);
        $roleTypes = $this->DirectoryGroups->RoleTypes->find('list', ['limit' => 200]);
        $this->set(compact('directoryGroup', 'directories', 'roleTypes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Directory Group id.
     * @return void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null): void
    {
        $this->request->allowMethod(['post', 'delete']);
        $directoryGroup = $this->DirectoryGroups->get($id);
        if ($this->DirectoryGroups->delete($directoryGroup)) {
            $this->Flash->success(__('The directory group has been deleted.'));
        } else {
            $this->Flash->error(__('The directory group could not be deleted. Please, try again.'));
        }

        $this->redirect(['action' => 'index']);
    }
}

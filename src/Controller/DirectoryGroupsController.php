<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\DirectoryGroup;
use App\Model\Table\DirectoryGroupsTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;

/**
 * DirectoryGroups Controller
 *
 * @property DirectoryGroupsTable $DirectoryGroups
 * @method DirectoryGroup[]|ResultSetInterface paginate($object = null, array $settings = [])
 */

class DirectoryGroupsController extends AppController
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
        $directoryGroups = $this->paginate($this->DirectoryGroups);

        $this->set(compact('directoryGroups'));
    }

    /**
     * View method
     *
     * @param null $id Directory Group id.
     * @return Response|void
     * @throws RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $directoryGroup = $this->DirectoryGroups->get($id, [
            'contain' => ['Directories', 'RoleTypes'],
        ]);

        $this->set('directoryGroup', $directoryGroup);
    }

    /**
     * Add method
     *
     * @return Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $directoryGroup = $this->DirectoryGroups->newEmptyEntity();
        if ($this->request->is('post')) {
            $directoryGroup = $this->DirectoryGroups->patchEntity($directoryGroup, $this->request->getData());
            if ($this->DirectoryGroups->save($directoryGroup)) {
                $this->Flash->success(__('The directory group has been saved.'));

                return $this->redirect(['action' => 'view', $directoryGroup->get(DirectoryGroup::FIELD_ID)]);
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
     * @return Response|void Redirects on successful edit, renders view otherwise.
     * @throws RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $directoryGroup = $this->DirectoryGroups->get($id, [
            'contain' => ['RoleTypes'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $directoryGroup = $this->DirectoryGroups->patchEntity($directoryGroup, $this->request->getData());
            if ($this->DirectoryGroups->save($directoryGroup)) {
                $this->Flash->success(__('The directory group has been saved.'));

                return $this->redirect(['action' => 'view', $directoryGroup->get(DirectoryGroup::FIELD_ID)]);
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
     * @return Response|null Redirects to index.
     * @throws RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $directoryGroup = $this->DirectoryGroups->get($id);
        if ($this->DirectoryGroups->delete($directoryGroup)) {
            $this->Flash->success(__('The directory group has been deleted.'));
        } else {
            $this->Flash->error(__('The directory group could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

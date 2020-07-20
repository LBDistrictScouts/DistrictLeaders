<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\Directory;
/**
 * Directories Controller
 *
 * @property \App\Model\Table\DirectoriesTable $Directories
 *
 * @method \App\Model\Entity\Directory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DirectoriesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
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
     * @param string|null $DirectoryId Directory id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $directory = $this->Directories->get($id, [
            'contain' => ['DirectoryTypes', 'DirectoryDomains', 'DirectoryGroups', 'DirectoryUsers'],
        ]);

        $this->set('directory', $directory);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
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
     * @param string|null $id Directory id.
     * @return \Cake\Http\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $directory = $this->Directories->get($id, [
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
     * Delete method
     *
     * @param string|null $id Directory id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $directory = $this->Directories->get($id);
        if ($this->Directories->delete($directory)) {
            $this->Flash->success(__('The directory has been deleted.'));
        } else {
            $this->Flash->error(__('The directory could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

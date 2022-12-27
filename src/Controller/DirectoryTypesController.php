<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\DirectoryType;
use App\Model\Table\DirectoryTypesTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;

/**
 * DirectoryTypes Controller
 *
 * @property DirectoryTypesTable $DirectoryTypes
 * @method DirectoryType[]|ResultSetInterface paginate($object = null, array $settings = [])
 */

class DirectoryTypesController extends AppController
{
    /**
     * Index method
     *
     * @return Response|void
     */
    public function index()
    {
        $directoryTypes = $this->paginate($this->DirectoryTypes);

        $this->set(compact('directoryTypes'));
    }

    /**
     * View method
     *
     * @param null $id Directory Type id.
     * @return Response|void
     * @throws RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $directoryType = $this->DirectoryTypes->get($id, [
            'contain' => ['Directories'],
        ]);

        $this->set('directoryType', $directoryType);
    }

    /**
     * Add method
     *
     * @return Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
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
     * @return Response|void Redirects on successful edit, renders view otherwise.
     * @throws RecordNotFoundException When record not found.
     */
    public function edit($id = null)
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
     * @return Response|null Redirects to index.
     * @throws RecordNotFoundException When record not found.
     */
    public function delete($id = null)
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

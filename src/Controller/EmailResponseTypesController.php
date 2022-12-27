<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\EmailResponseType;
use App\Model\Table\EmailResponseTypesTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;

/**
 * EmailResponseTypes Controller
 *
 * @property EmailResponseTypesTable $EmailResponseTypes
 * @method EmailResponseType[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmailResponseTypesController extends AppController
{
    /**
     * Index method
     *
     * @return Response|void
     */
    public function index()
    {
        $emailResponseTypes = $this->paginate($this->EmailResponseTypes);

        $this->set(compact('emailResponseTypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Email Response Type id.
     * @return Response|void
     * @throws RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $emailResponseType = $this->EmailResponseTypes->get($id, [
            'contain' => ['EmailResponses'],
        ]);

        $this->set('emailResponseType', $emailResponseType);
    }

    /**
     * Add method
     *
     * @return Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $emailResponseType = $this->EmailResponseTypes->newEmptyEntity();
        if ($this->request->is('post')) {
            $emailResponseType = $this->EmailResponseTypes->patchEntity($emailResponseType, $this->request->getData());
            if ($this->EmailResponseTypes->save($emailResponseType)) {
                $this->Flash->success(__('The email response type has been saved.'));

                return $this->redirect(['action' => 'view', $emailResponseType->get('id')]);
            }
            $this->Flash->error(__('The email response type could not be saved. Please, try again.'));
        }
        $this->set(compact('emailResponseType'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Email Response Type id.
     * @return Response|null Redirects on successful edit, renders view otherwise.
     * @throws RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $emailResponseType = $this->EmailResponseTypes->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $emailResponseType = $this->EmailResponseTypes->patchEntity($emailResponseType, $this->request->getData());
            if ($this->EmailResponseTypes->save($emailResponseType)) {
                $this->Flash->success(__('The email response type has been saved.'));

                return $this->redirect(['action' => 'view', $emailResponseType->get('id')]);
            }
            $this->Flash->error(__('The email response type could not be saved. Please, try again.'));
        }
        $this->set(compact('emailResponseType'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Email Response Type id.
     * @return Response|null Redirects to index.
     * @throws RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $emailResponseType = $this->EmailResponseTypes->get($id);
        if ($this->EmailResponseTypes->delete($emailResponseType)) {
            $this->Flash->success(__('The email response type has been deleted.'));
        } else {
            $this->Flash->error(__('The email response type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

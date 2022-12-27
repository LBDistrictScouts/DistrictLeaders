<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\EmailResponse;
use App\Model\Table\EmailResponsesTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;

/**
 * EmailResponses Controller
 *
 * @property EmailResponsesTable $EmailResponses
 * @method EmailResponse[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmailResponsesController extends AppController
{
    /**
     * Index method
     *
     * @return Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['EmailSends', 'EmailResponseTypes'],
        ];
        $emailResponses = $this->paginate($this->EmailResponses);

        $this->set(compact('emailResponses'));
    }

    /**
     * View method
     *
     * @param string|null $id Email Response id.
     * @return Response|void
     * @throws RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $emailResponse = $this->EmailResponses->get($id, [
            'contain' => ['EmailSends', 'EmailResponseTypes'],
        ]);

        $this->set('emailResponse', $emailResponse);
    }

    /**
     * Add method
     *
     * @return Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $emailResponse = $this->EmailResponses->newEmptyEntity();
        if ($this->request->is('post')) {
            $emailResponse = $this->EmailResponses->patchEntity($emailResponse, $this->request->getData());
            if ($this->EmailResponses->save($emailResponse)) {
                $this->Flash->success(__('The email response has been saved.'));

                return $this->redirect(['action' => 'view', $emailResponse->get('id')]);
            }
            $this->Flash->error(__('The email response could not be saved. Please, try again.'));
        }
        $emailSends = $this->EmailResponses->EmailSends->find('list', ['limit' => 200]);
        $emailResponseTypes = $this->EmailResponses->EmailResponseTypes->find('list', ['limit' => 200]);
        $this->set(compact('emailResponse', 'emailSends', 'emailResponseTypes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Email Response id.
     * @return Response|null Redirects on successful edit, renders view otherwise.
     * @throws RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $emailResponse = $this->EmailResponses->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $emailResponse = $this->EmailResponses->patchEntity($emailResponse, $this->request->getData());
            if ($this->EmailResponses->save($emailResponse)) {
                $this->Flash->success(__('The email response has been saved.'));

                return $this->redirect(['action' => 'view', $emailResponse->get('id')]);
            }
            $this->Flash->error(__('The email response could not be saved. Please, try again.'));
        }
        $emailSends = $this->EmailResponses->EmailSends->find('list', ['limit' => 200]);
        $emailResponseTypes = $this->EmailResponses->EmailResponseTypes->find('list', ['limit' => 200]);
        $this->set(compact('emailResponse', 'emailSends', 'emailResponseTypes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Email Response id.
     * @return Response|null Redirects to index.
     * @throws RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $emailResponse = $this->EmailResponses->get($id);
        if ($this->EmailResponses->delete($emailResponse)) {
            $this->Flash->success(__('The email response has been deleted.'));
        } else {
            $this->Flash->error(__('The email response could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

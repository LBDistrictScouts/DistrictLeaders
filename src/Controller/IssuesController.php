<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\Issue;
use Cake\Controller\Controller;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ModelAwareTrait;
use Cake\Event\Event;
use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\ORM\Table;

/**
 * Issues Controller
 *
 * @method Issue[]|ResultSetInterface paginate($object = null, array $settings = [])
 * @property Table $Issues
 */
class IssuesController extends Controller
{
    use ModelAwareTrait;

    /**
     * @param Event $event The event being interrupted
     * @return Response|void|null
     */
    public function beforeFilter(EventInterface $event)
    {
        $this->modelFactory('Endpoint', ['Muffin\Webservice\Model\EndpointRegistry', 'get']);
        $this->loadModel('CvoTechnologies/GitHub.Issues', 'Endpoint');
    }

    /**
     * Index method
     *
     * @return Response|void
     */
    public function index()
    {
        $issues = $this->Issues->find()->where([
            'owner' => 'LBDistrictScouts',
            'repo' => 'DistrictLeaders',
        ]);

        $this->set(compact('issues'));
    }

    /**
     * View method
     *
     * @param string|null $id Issue id.
     * @return Response|void
     * @throws RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $issue = $this->Issues->get($id, [
            'contain' => [],
        ]);

        $this->set('issue', $issue);
    }

    /**
     * Add method
     *
     * @return Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $issue = $this->Issues->newEmptyEntity();
        if ($this->request->is('post')) {
            $issue = $this->Issues->patchEntity($issue, $this->request->getData());
            if ($this->Issues->save($issue)) {
                $this->Flash->success(__('The issue has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The issue could not be saved. Please, try again.'));
        }
        $this->set(compact('issue'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Issue id.
     * @return Response|null Redirects on successful edit, renders view otherwise.
     * @throws RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $issue = $this->Issues->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $issue = $this->Issues->patchEntity($issue, $this->request->getData());
            if ($this->Issues->save($issue)) {
                $this->Flash->success(__('The issue has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The issue could not be saved. Please, try again.'));
        }
        $this->set(compact('issue'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Issue id.
     * @return Response|null Redirects to index.
     * @throws RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $issue = $this->Issues->get($id);
        if ($this->Issues->delete($issue)) {
            $this->Flash->success(__('The issue has been deleted.'));
        } else {
            $this->Flash->error(__('The issue could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Datasource\ModelAwareTrait;
use Cake\Event\EventInterface;

/**
 * Issues Controller
 *
 * @method \App\Model\Entity\Issue[]|\App\Controller\ResultSetInterface paginate($object = null, array $settings = [])
 * @property \Cake\ORM\Table $Issues
 */
class IssuesController extends Controller
{
    use ModelAwareTrait;

    /**
     * @param \Cake\Event\Event $event The event being interrupted
     * @return \App\Controller\Response|null
     */
    public function beforeFilter(EventInterface $event): void
    {
        $this->modelFactory('Endpoint', ['Muffin\Webservice\Model\EndpointRegistry', 'get']);
        $this->loadModel('CvoTechnologies/GitHub.Issues', 'Endpoint');

        return null;
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index(): void
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
     * @return void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null): void
    {
        $issue = $this->Issues->get($id, [
            'contain' => [],
        ]);

        $this->set('issue', $issue);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add(): void
    {
        $issue = $this->Issues->newEmptyEntity();
        if ($this->request->is('post')) {
            $issue = $this->Issues->patchEntity($issue, $this->request->getData());
            if ($this->Issues->save($issue)) {
                $this->Flash->success(__('The issue has been saved.'));

                $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The issue could not be saved. Please, try again.'));
        }
        $this->set(compact('issue'));

        return null;
    }

    /**
     * Edit method
     *
     * @param string|null $id Issue id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null): void
    {
        $issue = $this->Issues->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $issue = $this->Issues->patchEntity($issue, $this->request->getData());
            if ($this->Issues->save($issue)) {
                $this->Flash->success(__('The issue has been saved.'));

                $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The issue could not be saved. Please, try again.'));
        }
        $this->set(compact('issue'));

        return null;
    }

    /**
     * Delete method
     *
     * @param string|null $id Issue id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null): void
    {
        $this->request->allowMethod(['post', 'delete']);
        $issue = $this->Issues->get($id);
        if ($this->Issues->delete($issue)) {
            $this->Flash->success(__('The issue has been deleted.'));
        } else {
            $this->Flash->error(__('The issue could not be deleted. Please, try again.'));
        }

        $this->redirect(['action' => 'index']);
    }
}

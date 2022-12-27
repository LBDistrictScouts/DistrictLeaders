<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\ScoutGroup;
use App\Model\Entity\SectionType;
use App\Model\Table\ScoutGroupsTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\Response;

/**
 * ScoutGroups Controller
 *
 * @property ScoutGroupsTable $ScoutGroups
 * @method ScoutGroup[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class ScoutGroupsController extends AppController
{
    /**
     * @inheritDoc
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->whyPermitted($this->ScoutGroups);
    }

    /**
     * Index method
     *
     * @return Response|void
     */
    public function index()
    {
        $this->Authorization->authorize($this->ScoutGroups);

        $query = $this->ScoutGroups->find()->contain([
            'Sections.SectionTypes',
        ]);
        $scoutGroups = $this->paginate($this->Authorization->applyScope($query));

        $this->set(compact('scoutGroups'));

        $this->whyPermitted($this->ScoutGroups);
    }

    /**
     * Index method
     *
     * @return Response|void
     */
    public function generate()
    {
        $this->Authorization->authorize($this->ScoutGroups);

        if ($this->request->is('post')) {
            $postData = $this->request->getData();
            foreach ($postData as $groupId => $groupGenerate) {
                foreach ($groupGenerate as $sectionTypeId => $sectionGenerate) {
                    if ($sectionGenerate['generate']) {
                        $this->ScoutGroups->Sections->makeStandard($groupId, $sectionTypeId);
                    }
                }
            }
        }

        $scoutGroupsFinder = $this->ScoutGroups->find()->contain(['Sections']);
        $sectionTypes = $this->ScoutGroups->Sections->SectionTypes
            ->find()
            ->orderAsc(SectionType::FIELD_SECTION_TYPE);
        $scoutGroups = [];

        /** @var ScoutGroup $scoutGroup */
        foreach ($scoutGroupsFinder as $idx => $scoutGroup) {
            $matrix = [];

            /** @var SectionType $sectionType */
            foreach ($sectionTypes as $sectionType) {
                if ($sectionType->is_young_person_section) {
                    $count = 0;
                    foreach ($scoutGroup->sections as $section) {
                        if ($section->section_type_id == $sectionType->id) {
                            $count += 1;
                        }
                    }
                    $array = [
                        'count' => $count,
                        'exists' => (bool)($count > 0),
                    ];
                    $matrix[$sectionType->id] = $array;
                }
            }
            $scoutGroup->set('matrix', $matrix);
            $scoutGroups[$idx] = $scoutGroup;
        }

        $this->set(compact('scoutGroups', 'sectionTypes'));

        $this->whyPermitted($this->ScoutGroups);
    }

    /**
     * View method
     *
     * @param string|null $id Scout Group id.
     * @return Response|void
     * @throws RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $scoutGroup = $this->ScoutGroups->get($id, [
            'contain' => [
                'Sections' => [
                    'SectionTypes',
                    'Roles' => [
                        'Users',
                        'UserContacts',
                        'RoleTypes',
                    ],
                ],
                'LeaderSections' => [
                    'SectionTypes',
                    'Roles' => [
                        'Users',
                        'UserContacts',
                        'RoleTypes',
                    ],
                ],
                'CommitteeSections' => [
                    'SectionTypes',
                    'Roles' => [
                        'Users',
                        'UserContacts',
                        'RoleTypes',
                    ],
                ],
                'TeamSections' => [
                    'SectionTypes',
                    'Roles' => [
                        'Users',
                        'UserContacts',
                        'RoleTypes',
                    ],
                ],
                'Audits.Users',
            ],
        ]);

        $this->set('scoutGroup', $scoutGroup);
    }

    /**
     * Add method
     *
     * @return Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $scoutGroup = $this->ScoutGroups->newEmptyEntity();
        if ($this->request->is('post')) {
            $scoutGroup = $this->ScoutGroups->patchEntity($scoutGroup, $this->request->getData());
            if ($this->ScoutGroups->save($scoutGroup)) {
                $this->Flash->success(__('The scout group has been saved.'));

                return $this->redirect(['action' => 'view', $scoutGroup->get(ScoutGroup::FIELD_ID)]);
            }
            $this->Flash->error(__('The scout group could not be saved. Please, try again.'));
        }
        $this->set(compact('scoutGroup'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Scout Group id.
     * @return Response|void Redirects on successful edit, renders view otherwise.
     * @throws RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $scoutGroup = $this->ScoutGroups->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $scoutGroup = $this->ScoutGroups->patchEntity($scoutGroup, $this->request->getData());
            if ($this->ScoutGroups->save($scoutGroup)) {
                $this->Flash->success(__('The scout group has been saved.'));

                return $this->redirect(['action' => 'view', $scoutGroup->get(ScoutGroup::FIELD_ID)]);
            }
            $this->Flash->error(__('The scout group could not be saved. Please, try again.'));
        }
        $this->set(compact('scoutGroup'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Scout Group id.
     * @return Response|null Redirects to index.
     * @throws RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $scoutGroup = $this->ScoutGroups->get($id);
        if ($this->ScoutGroups->delete($scoutGroup)) {
            $this->Flash->success(__('The scout group has been deleted.'));
        } else {
            $this->Flash->error(__('The scout group could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

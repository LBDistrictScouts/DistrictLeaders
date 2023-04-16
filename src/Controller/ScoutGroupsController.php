<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\ScoutGroup;
use App\Model\Entity\SectionType;

/**
 * ScoutGroups Controller
 *
 * @property \App\Model\Table\ScoutGroupsTable $ScoutGroups
 * @method \App\Model\Entity\ScoutGroup[]|\App\Controller\ResultSetInterface paginate($object = null, array $settings = [])
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
     * @return \Cake\Http\Response|void
     */
    public function index(): ?Response
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
     * @return \Cake\Http\Response|void
     */
    public function generate(): ?Response
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

        /** @var \App\Model\Entity\ScoutGroup $scoutGroup */
        foreach ($scoutGroupsFinder as $idx => $scoutGroup) {
            $matrix = [];

            /** @var \App\Model\Entity\SectionType $sectionType */
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
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null): ?Response
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
     * @return \Cake\Http\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add(): ?Response
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
     * @return \Cake\Http\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null): ?Response
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
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null): ?Response
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

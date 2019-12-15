<?php
namespace App\Model\Index;

use App\Model\Document\ContactDocument;
use Cake\Core\Configure;
use Cake\ElasticSearch\Index;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Class ContactsIndex
 *
 * @package App\Model\Index
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class ContactsIndex extends Index
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

//        $this->embedMany('Emails');
    }

    /**
     * The name of index in Elasticsearch
     *
     * @return  string
     */
    public function getName()
    {
        return Configure::read('elasticEnv') . '_' . 'contacts';
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer(ContactDocument::FIELD_ID)
            ->allowEmptyString(ContactDocument::FIELD_ID, 'An ID must be set.', 'create');

        $validator
            ->integer(ContactDocument::FIELD_MEMBERSHIP_NUMBER)
            ->requirePresence(ContactDocument::FIELD_MEMBERSHIP_NUMBER, 'create')
            ->notEmptyString(ContactDocument::FIELD_MEMBERSHIP_NUMBER, 'A unique, valid TSA membership number is required.');

        $validator
            ->scalar(ContactDocument::FIELD_FIRST_NAME)
            ->requirePresence(ContactDocument::FIELD_FIRST_NAME, 'create')
            ->notEmptyString(ContactDocument::FIELD_FIRST_NAME);

        $validator
            ->scalar(ContactDocument::FIELD_LAST_NAME)
            ->requirePresence(ContactDocument::FIELD_LAST_NAME, 'create')
            ->notEmptyString(ContactDocument::FIELD_LAST_NAME);

        $validator
            ->scalar(ContactDocument::FIELD_FULL_NAME)
            ->requirePresence(ContactDocument::FIELD_FULL_NAME, 'create')
            ->notEmptyString(ContactDocument::FIELD_FULL_NAME);

        return $validator;
    }

    /**
     * Function to reindex Users
     *
     * @return bool
     */
    public function reindexUsers()
    {
        $this->Users = TableRegistry::getTableLocator()->get('Users');
        $passCount = 0;
        $iterationCount = 0;
        $userCount = $this->Users->find()->count();

        $allUsers = $this->Users->find();

        /** @var \App\Model\Entity\User $user */
        foreach ($allUsers as $user) {
            $iterationCount += 1;
            $userData = [
                ContactDocument::FIELD_ID => $user->get($user::FIELD_ID),
                ContactDocument::FIELD_MEMBERSHIP_NUMBER => $user->get($user::FIELD_MEMBERSHIP_NUMBER),
                ContactDocument::FIELD_FIRST_NAME => $user->get($user::FIELD_FIRST_NAME),
                ContactDocument::FIELD_LAST_NAME => $user->get($user::FIELD_LAST_NAME),
                ContactDocument::FIELD_FULL_NAME => $user->get($user::FIELD_FULL_NAME),
            ];
            $contactEntity = $this->newEntity($userData);
            debug($contactEntity);
            if ($this->save($contactEntity) instanceof ContactDocument) {
                $passCount += 1;
            }
        }

        if ($iterationCount == $userCount && $passCount == $userCount) {
            return true;
        }

        return false;
    }
}

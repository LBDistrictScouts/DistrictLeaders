<?php
declare(strict_types=1);

namespace App\Model\Index;

use App\Model\Document\EmailDocument;
use Cake\ElasticSearch\Index;
use Cake\Validation\Validator;

/**
 * Class EmailsIndex
 *
 * @package App\Model\Index
 */
class EmailsIndex extends Index
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

        $this->embedOne('User');
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
            ->integer(EmailDocument::FIELD_ID)
            ->allowEmptyString(EmailDocument::FIELD_ID, 'An ID must be set.', 'create');

        $validator
            ->scalar(EmailDocument::FIELD_EMAIL)
            ->maxLength(EmailDocument::FIELD_EMAIL, 255)
            ->requirePresence(EmailDocument::FIELD_EMAIL, 'create')
            ->notEmptyString(EmailDocument::FIELD_EMAIL);

        return $validator;
    }
}

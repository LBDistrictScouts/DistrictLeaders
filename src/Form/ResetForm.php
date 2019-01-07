<?php
namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

/**
 * Reset Form.
 */
class ResetForm extends Form
{
    /**
     * Build the Schema of the form.
     *
     * @param Schema $schema The basic Schema to be Extended
     *
     * @return Schema $schema
     */
    protected function _buildSchema(Schema $schema)
    {
        $schema
            ->addField('membership_number', 'integer')
            ->addField('first_name', 'varchar')
            ->addField('last_name', 'varchar')
            ->addField('email', 'varchar');

        return $schema;
    }

    /**
     * Function to Validate the Form
     *
     * @param Validator $validator The basic Validation to be extended.
     *
     * @return Validator $validator
     */
    protected function _buildValidator(Validator $validator)
    {
        $validator
            ->requirePresence('membership_number')
            ->allowEmptyString('membership_number', false);

        $validator
            ->email('email', 'valid')
            ->allowEmptyString('email', false);

        $validator
            ->scalar('first_name')
            ->allowEmptyString('first_name', false);

        $validator
            ->scalar('last_name')
            ->allowEmptyString('last_name', false);

        return $validator;
    }
}

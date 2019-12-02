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
            ->addField(self::FIELD_MEMBERSHIP_NUMBER, 'integer')
            ->addField(self::FIELD_FIRST_NAME, 'varchar')
            ->addField(self::FIELD_LAST_NAME, 'varchar')
            ->addField(self::FIELD_EMAIL, 'varchar');

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
            ->requirePresence(self::FIELD_MEMBERSHIP_NUMBER)
            ->integer(self::FIELD_MEMBERSHIP_NUMBER, 'Please enter a valid TSA Membership Number.')
            ->notEmptyString(self::FIELD_MEMBERSHIP_NUMBER);

        $validator
            ->requirePresence(self::FIELD_EMAIL)
            ->email(self::FIELD_EMAIL, 'valid', 'Please Enter Valid Email Address.')
            ->notEmptyString(self::FIELD_EMAIL);

        $validator
            ->scalar(self::FIELD_FIRST_NAME)
            ->notEmptyString(self::FIELD_FIRST_NAME);

        $validator
            ->scalar(self::FIELD_LAST_NAME)
            ->notEmptyString(self::FIELD_LAST_NAME);

        return $validator;
    }

    public const FIELD_MEMBERSHIP_NUMBER = 'membership_number';
    public const FIELD_EMAIL = 'email';
    public const FIELD_FIRST_NAME = 'first_name';
    public const FIELD_LAST_NAME = 'last_name';
}

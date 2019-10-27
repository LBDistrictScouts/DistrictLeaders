<?php
namespace App\Form;

use App\Model\Entity\User;
use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Password Form.
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class PasswordForm extends Form
{
    /**
     * Builds the schema for the modelless form
     *
     * @param \Cake\Form\Schema $schema From schema
     * @return \Cake\Form\Schema
     */
    protected function _buildSchema(Schema $schema)
    {
        $schema->addField(self::FIELD_NEW_PASSWORD, 'string')
            ->addField(self::FIELD_CONFIRM_PASSWORD, 'string')
            ->addField(self::FIELD_POSTCODE, 'string');

        return $schema;
    }

    /**
     * Form validation builder
     *
     * @param \Cake\Validation\Validator $validator to use against the form
     * @return \Cake\Validation\Validator
     */
    protected function _buildValidator(Validator $validator)
    {
        $validator->minLength(self::FIELD_POSTCODE, 6, 'Postcode is too Short.')
            ->minLength(self::FIELD_NEW_PASSWORD, User::MINIMUM_PASSWORD_LENGTH, 'Password is too short.')
            ->equalToField(self::FIELD_CONFIRM_PASSWORD, self::FIELD_NEW_PASSWORD, 'Passwords don\'t match');

        return $validator;
    }

    /**
     * Defines what to execute once the From is being processed
     *
     * @param array $data Form data.
     *
     * @return bool
     */
    protected function _execute(array $data)
    {
        // Check Request is included
        if (key_exists('request', $data)) {
            $requestData = $data['request'];
        } else {
            return false;
        }

        // Check passwords Match
        if (key_exists(self::FIELD_NEW_PASSWORD, $requestData)
            && key_exists(self::FIELD_CONFIRM_PASSWORD, $requestData)) {
            $newPassword = $requestData[self::FIELD_NEW_PASSWORD];
            $confirm = $requestData[self::FIELD_CONFIRM_PASSWORD];

            if ($newPassword != $confirm) {
                return false;
            }
        } else {
            return false;
        }

        if (key_exists('user', $data) && key_exists(self::FIELD_POSTCODE, $requestData)) {
            /** @var \App\Model\Entity\User $user */
            $user = $data['user'];

            $formPostcode = str_replace(" ", "", strtoupper($requestData[self::FIELD_POSTCODE]));
            $userPostcode = str_replace(" ", "", strtoupper($user->get($user::FIELD_POSTCODE)));

            if ($formPostcode != $userPostcode) {
                return false;
            }
        } else {
            return false;
        }

        $this->Users = TableRegistry::getTableLocator()->get('Users');
        $user = $this->Users->patchEntity($user, [User::FIELD_PASSWORD => $newPassword], [ 'fields' => [$user::FIELD_PASSWORD], 'validate' => false ]);

        if ($this->Users->save($user)) {
            return true;
        }

        return false;
    }

    public const FIELD_NEW_PASSWORD = 'newpw';
    public const FIELD_CONFIRM_PASSWORD = 'confirm';
    public const FIELD_POSTCODE = 'postcode';
}

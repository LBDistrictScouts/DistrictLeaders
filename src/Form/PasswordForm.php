<?php

declare(strict_types=1);

namespace App\Form;

use App\Model\Entity\User;
use App\Model\Table\UsersTable;
use Cake\Datasource\ModelAwareTrait;
use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

/**
 * Password Form.
 *
 * @property UsersTable $Users
 */
class PasswordForm extends Form
{
    use ModelAwareTrait;

    /**
     * Builds the schema for the modelless form
     *
     * @param Schema $schema From schema
     * @return Schema
     */
    protected function buildSchema(Schema $schema): Schema
    {
        $schema
            ->addField(self::FIELD_NEW_PASSWORD, 'string')
            ->addField(self::FIELD_CONFIRM_PASSWORD, 'string')
            ->addField(self::FIELD_POSTCODE, 'string');

        return $schema;
    }

    /**
     * Form validation builder
     *
     * @param Validator $validator to use against the form
     * @return Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->minLength(self::FIELD_NEW_PASSWORD, User::MINIMUM_PASSWORD_LENGTH, 'Password is too short.');

        $validator
            ->requirePresence(self::FIELD_CONFIRM_PASSWORD)
            ->equalToField(self::FIELD_CONFIRM_PASSWORD, self::FIELD_NEW_PASSWORD, 'Passwords don\'t match');

        $validator
            ->minLength(self::FIELD_POSTCODE, 6, 'Postcode is too Short.');

        return $validator;
    }

    /**
     * Defines what to execute once the From is being processed
     *
     * @param array $data Form data.
     * @return bool
     */
    protected function _execute(array $data): bool
    {
        $this->loadModel('Users');

        // Check Request is included
        if (key_exists('request', $data)) {
            $requestData = $data['request'];
        } else {
            $requestData = $data;
        }

        // Check passwords Match
        if (
            key_exists(self::FIELD_NEW_PASSWORD, $requestData)
            && key_exists(self::FIELD_CONFIRM_PASSWORD, $requestData)
        ) {
            $newPassword = $requestData[self::FIELD_NEW_PASSWORD];
            $confirm = $requestData[self::FIELD_CONFIRM_PASSWORD];

            if ($newPassword != $confirm) {
                return false;
            }
        } else {
            return false;
        }

        if (key_exists('user', $data) && key_exists(self::FIELD_POSTCODE, $requestData)) {
            /** @var User $user */
            $user = $data['user'];

            if (!$user instanceof User) {
                return false;
            }

            $formPostcode = str_replace(' ', '', strtoupper($requestData[self::FIELD_POSTCODE]));
            $userPostcode = str_replace(' ', '', strtoupper($user->get($user::FIELD_POSTCODE)));

            if ($formPostcode != $userPostcode) {
                return false;
            }
        } else {
            return false;
        }

        $user = $this->Users->patchEntity(
            $user,
            [User::FIELD_PASSWORD => $newPassword],
            [ 'fields' => [$user::FIELD_PASSWORD], 'validate' => false ]
        );

        if ($this->Users->save($user)) {
            return true;
        }

        return false;
    }

    public const FIELD_NEW_PASSWORD = 'new_password';
    public const FIELD_CONFIRM_PASSWORD = 'confirm_password';
    public const FIELD_POSTCODE = 'postcode';
}

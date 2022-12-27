<?php

declare(strict_types=1);

namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;

/**
 * GoogleAuth Form.
 */
class GoogleAuthForm extends Form
{
    /**
     * Builds the schema for the modelless form
     *
     * @param Schema $schema From schema
     * @return Schema
     */
    protected function buildSchema(Schema $schema): Schema
    {
        $schema
            ->addField(self::FIELD_AUTH_CODE, 'string');

        return $schema;
    }

    /**
     * Defines what to execute once the Form is processed
     *
     * @param array $data Form data.
     * @return bool
     */
    protected function _execute(array $data): bool
    {
        return true;
    }

    public const FIELD_AUTH_CODE = 'auth_code';
}

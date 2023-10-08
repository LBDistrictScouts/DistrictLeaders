<?php

declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AuditsFixture
 */
class AuditsFixture extends TestFixture
{
    // @codingStandardsIgnoreEnd
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'audit_field' => 'first_name',
                'audit_table' => 'Users',
                'original_value' => 'old',
                'modified_value' => 'new',
                'user_id' => 1,
                'audit_record_id' => 1,
                'change_date' => 1545697741,
            ],
        ];
        parent::init();
    }
}

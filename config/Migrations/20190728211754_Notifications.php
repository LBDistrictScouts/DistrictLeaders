<?php

use Migrations\AbstractMigration;

class Notifications extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $this
            ->table('notification_types')
            ->addColumn('notification_type', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('notification_description', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('icon', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('type_code', 'string', [
                'limit' => 7,
                'null' => false,
                'default' => 'ABC-DEF',
            ])
            ->save();

        $this
            ->table('notifications')
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('notification_type_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('new', 'boolean', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('notification_header', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('text', 'string', [
                'default' => null,
                'limit' => 999,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('read_date', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('notification_source', 'string', [
                'default' => null,
                'limit' => 63,
                'null' => true,
            ])
            ->addColumn('link_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('link_controller', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('link_prefix', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('link_action', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'notification_type_id',
                ]
            )
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->save();

        $this
            ->table('email_sends')
            ->addColumn('email_generation_code', 'string', [
                'limit' => 30,
                'null' => true,
            ])
            ->addColumn('email_template', 'string', [
                'limit' => 30,
                'null' => true,
            ])
            ->addColumn('include_token', 'boolean', [
                'default' => false,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('sent', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('message_send_code', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('subject', 'string', [
                'default' => null,
                'limit' => 511,
                'null' => true,
            ])
            ->addColumn('routing_domain', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('from_address', 'string', [
                'default' => null,
                'limit' => 511,
                'null' => true,
            ])
            ->addColumn('friendly_from', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('notification_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex('message_send_code')
            ->addIndex('user_id')
            ->addIndex('notification_id')
            ->addForeignKey(
                'user_id',
                'users',
                ['id'],
                [
                    'delete' => 'RESTRICT',
                    'update' => 'CASCADE',
                ]
            )
            ->addForeignKey(
                'notification_id',
                'notifications',
                'id',
                [
                    'delete' => 'RESTRICT',
                    'update' => 'CASCADE',
                ]
            )
            ->save();

        $this
            ->table('email_response_types')
            ->addColumn('email_response_type', 'string', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('bounce', 'boolean', [
                'default' => false,
                'null' => false,
            ])
            ->save();

        $this
            ->table('email_responses')
            ->addColumn('email_send_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('email_response_type_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('received', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('link_clicked', 'string', [
                'default' => null,
                'limit' => 511,
                'null' => true,
            ])
            ->addColumn('ip_address', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('bounce_reason', 'string', [
                'default' => null,
                'limit' => 511,
                'null' => true,
            ])
            ->addColumn('message_size', 'integer', [
                'default' => null,
                'null' => true,
            ])
            ->addIndex('email_send_id')
            ->addIndex('email_response_type_id')
            ->addForeignKey(
                'email_send_id',
                'email_sends',
                'id',
                [
                    'delete' => 'RESTRICT',
                    'update' => 'CASCADE',
                ]
            )
            ->addForeignKey(
                'email_response_type_id',
                'email_response_types',
                'id',
                [
                    'delete' => 'RESTRICT',
                    'update' => 'CASCADE',
                ]
            )
            ->save();

        $this
            ->table('tokens')
            ->removeColumn('user_id')
            ->addColumn('email_send_id', 'integer', [
                'default' => null,
                'null' => false,
            ])
            ->changeColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->changeColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->changeColumn('expires', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->changeColumn('utilised', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->changeColumn('active', 'boolean', [
                'default' => true,
                'null' => false,
            ])
            ->changeColumn('deleted', 'datetime', [
                'default' => null,
                'null' => true,
            ])
            ->changeColumn('hash', 'string', [
                'default' => null,
                'limit' => 511,
                'null' => true,
            ])
            ->changeColumn('random_number', 'integer', [
                'default' => null,
                'null' => true,
            ])
            ->renameColumn('header', 'token_header')
            ->changeColumn('token_header', 'json', [
                'null' => true,
            ])
            ->addIndex('email_send_id')
            ->addForeignKey(
                'email_send_id',
                'email_sends',
                'id',
                [
                    'delete' => 'RESTRICT',
                    'update' => 'CASCADE',
                ]
            )
            ->save();
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: jacob
 * Date: 2019-01-03
 * Time: 20:55
 */

use App\Model\Entity\NotificationType as NT;
use App\Model\Entity\FileType as FT;

return [

    'notificationTypes' => [
        [
            NT::FIELD_NOTIFICATION_TYPE => 'Generic',
            NT::FIELD_NOTIFICATION_DESCRIPTION => 'Generic Notification.',
            NT::FIELD_ICON => 'fa-envelope',
            NT::FIELD_TYPE_CODE => 'GEN-NOT',
        ],
        [
            NT::FIELD_NOTIFICATION_TYPE => 'Welcome',
            NT::FIELD_NOTIFICATION_DESCRIPTION => 'Welcome to the System Email & Notification.',
            NT::FIELD_ICON => 'fa-user',
            NT::FIELD_TYPE_CODE => 'USR-NEW',
        ],
        [
            NT::FIELD_NOTIFICATION_TYPE => 'Password Reset',
            NT::FIELD_NOTIFICATION_DESCRIPTION => 'A password reset password has been triggered.',
            NT::FIELD_ICON => 'fa-unlock',
            NT::FIELD_TYPE_CODE => 'USR-PWD',
        ],
        [
            NT::FIELD_NOTIFICATION_TYPE => 'Capabilities Change',
            NT::FIELD_NOTIFICATION_DESCRIPTION => 'Permissions / capabilities in the system have changed.',
            NT::FIELD_ICON => 'fa-key',
            NT::FIELD_TYPE_CODE => 'USR-CCH',
        ],
        [
            NT::FIELD_NOTIFICATION_TYPE => 'New Role Added',
            NT::FIELD_NOTIFICATION_DESCRIPTION => 'A new role has been added in the system.',
            NT::FIELD_ICON => 'fa-hierarchy',
            NT::FIELD_TYPE_CODE => 'ROL-NEW',
        ],
        [
            NT::FIELD_NOTIFICATION_TYPE => 'New Payment Received',
            NT::FIELD_NOTIFICATION_DESCRIPTION => 'Notification that a payment has been recorded by an administrator.',
            NT::FIELD_ICON => 'fa-receipt',
            NT::FIELD_TYPE_CODE => 'INV-PAY',
        ],
        [
            NT::FIELD_NOTIFICATION_TYPE => 'Surcharge Added',
            NT::FIELD_NOTIFICATION_DESCRIPTION => 'A Payment Surcharge was added to the Invoice.',
            NT::FIELD_ICON => 'fa-tag',
            NT::FIELD_TYPE_CODE => 'INV-SUR',
        ],
        [
            NT::FIELD_NOTIFICATION_TYPE => 'Outstanding Balance',
            NT::FIELD_NOTIFICATION_DESCRIPTION => 'Balance Outstanding on Invoice',
            NT::FIELD_ICON => 'fa-clock',
            NT::FIELD_TYPE_CODE => 'INV-OUT',
        ],
        [
            NT::FIELD_NOTIFICATION_TYPE => 'Invoice Attached',
            NT::FIELD_NOTIFICATION_DESCRIPTION => 'Invoice is attached to the email.',
            NT::FIELD_ICON => 'fa-paperclip',
            NT::FIELD_TYPE_CODE => 'INV-ATC',
        ],
        [
            NT::FIELD_NOTIFICATION_TYPE => 'Deposit Outstanding',
            NT::FIELD_NOTIFICATION_DESCRIPTION => 'Notification of an Invoice where the deposit is past due.',
            NT::FIELD_ICON => 'fa-clock',
            NT::FIELD_TYPE_CODE => 'INV-DEP',
        ],
    ],

    'fileTypes' => [
        [
            FT::FIELD_FILE_TYPE => 'Word',
            FT::FIELD_FILE_EXTENSION => 'docx',
            FT::FIELD_MIME => 'application/docx',
        ],
        [
            FT::FIELD_FILE_TYPE => 'PDF',
            FT::FIELD_FILE_EXTENSION => 'pdf',
            FT::FIELD_MIME => 'application/pdf',
        ],
        [
            FT::FIELD_FILE_TYPE => 'Old Word',
            FT::FIELD_FILE_EXTENSION => 'doc',
            FT::FIELD_MIME => 'application/doc',
        ],
        [
            FT::FIELD_FILE_TYPE => 'Comma Separated Value',
            FT::FIELD_FILE_EXTENSION => 'csv',
            FT::FIELD_MIME => 'application/csv',
        ],
    ],
];

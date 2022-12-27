<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link https://cakephp.org CakePHP(tm) Project
 * @since 1.0.0
 * @license https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Test\TestCase;

use App\Test\TestCase\Controller\AppTestTrait;
use Cake\Controller\Controller;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\TestSuite\TestCase;
use Queue\Model\Table\QueuedJobsTable;

/**
 * Class AuthenticationTestCase
 *
 * @package App\Test\TestCase
 * @property QueuedJobsTable $QueuedJobs
 */
class ComponentTestCase extends TestCase
{
    use LocatorAwareTrait;
    use AppTestTrait;

    public QueuedJobsTable $QueuedJobs;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.UserStates',
        'app.Users',
        'app.CapabilitiesRoleTypes',
        'app.Capabilities',
        'app.ScoutGroups',
        'app.SectionTypes',
        'app.Sections',

        'app.RoleTemplates',
        'app.RoleTypes',
        'app.RoleStatuses',

        'app.Audits',
        'app.UserContactTypes',
        'app.UserContacts',

        'app.DirectoryTypes',
        'app.Directories',
        'app.DirectoryDomains',
        'app.DirectoryUsers',
        'app.DirectoryGroups',
        'app.RoleTypesDirectoryGroups',

        'app.Roles',

        'app.NotificationTypes',
        'app.Notifications',

        'app.EmailSends',
        'app.Tokens',
        'app.EmailResponseTypes',
        'app.EmailResponses',

        'app.FileTypes',
        'app.DocumentTypes',
        'app.Documents',
        'app.DocumentVersions',
        'app.DocumentEditions',
        'app.CompassRecords',

        'app.CampTypes',
        'app.Camps',
        'app.CampRoleTypes',
        'app.CampRoles',

        'plugin.Queue.QueuedJobs',
        'plugin.Queue.QueueProcesses',

    ];

    /**
     * Test subject
     *
     * @var Controller
     */
    public Controller $Controller;

    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->QueuedJobs = $this->getTableLocator()->get('Queue.QueuedJobs');
    }
}

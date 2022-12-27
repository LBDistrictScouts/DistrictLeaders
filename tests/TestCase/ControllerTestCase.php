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
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\ORM\Table;
use Cake\TestSuite\TestCase;
use Queue\Model\Table\QueuedJobsTable;

/**
 * Class AuthenticationTestCase
 *
 * @package App\Test\TestCase
 * @property QueuedJobsTable $QueuedJobs
 */
class ControllerTestCase extends TestCase
{
    use LocatorAwareTrait;
    use AppTestTrait;

    public QueuedJobsTable|Table $QueuedJobs;

    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->QueuedJobs = $this->getTableLocator()->get('Queue.QueuedJobs');
    }
}

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
use Cake\Console\ConsoleOutput;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\TestSuite\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Queue\Queue\Task;

/**
 * Class AuthenticationTestCase
 *
 * @package App\Test\TestCase
 */
class QueueTestCase extends TestCase
{
    use LocatorAwareTrait;
    use AppTestTrait;

    /**
     * Test subject
     *
     * @var Task|MockObject
     */
    protected Task|MockObject $Task;

    /**
     * @var Table|QueuedJobsTable
     */
    protected $QueuedJobs;

    /**
     * @var \Tools\TestSuite\ConsoleOutput
     */
    protected $out;

    /**
     * @var \Tools\TestSuite\ConsoleOutput
     */
    protected $err;

    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->QueuedJobs = $this->getTableLocator()->get('Queue.QueuedJobs');

        $this->out = new ConsoleOutput();
        $this->err = new ConsoleOutput();
    }
}

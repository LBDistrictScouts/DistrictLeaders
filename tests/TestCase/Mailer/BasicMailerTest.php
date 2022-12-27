<?php

declare(strict_types=1);

namespace App\Test\TestCase\Mailer;

use App\Mailer\BasicMailer;
use Cake\TestSuite\EmailTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Mailer\BasicMailer Test Case
 */
class BasicMailerTest extends TestCase
{
    use EmailTrait;

    /**
     * Test subject
     *
     * @var BasicMailer
     */
    public $Basic;

    /**
     * Test doSend method
     *
     * @return void
     */
    public function testDoSend()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

<?php
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
     * @var \App\Mailer\BasicMailer
     */
    public $Basic;

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

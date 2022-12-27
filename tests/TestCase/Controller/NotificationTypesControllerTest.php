<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Model\Entity\NotificationType;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\NotificationTypesController Test Case
 *
 * @uses \App\Controller\NotificationTypesController
 */
class NotificationTypesControllerTest extends TestCase
{
    use AppTestTrait;

    /**
     * @var string $controller The Name of the controller being interrogated.
     */
    private string $controller = 'NotificationTypes';

    /**
     * @var array $validEntityData Valid creation Data.
     */
    private array $validEntityData = [
        NotificationType::FIELD_NOTIFICATION_TYPE => 'Testing',
        NotificationType::FIELD_NOTIFICATION_DESCRIPTION => 'Testing Notification.',
        NotificationType::FIELD_ICON => 'fa-envelope',
        NotificationType::FIELD_TYPE_CODE => 'GEN-TON',
        NotificationType::FIELD_CONTENT_TEMPLATE => 'standard',
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex(): void
    {
        $this->tryIndexGet($this->controller);
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView(): void
    {
        $this->tryViewGet($this->controller);
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd(): void
    {
        $this->tryAddGet($this->controller);

        $this->tryAddPost(
            $this->controller,
            $this->validEntityData,
            8
        );
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit(): void
    {
        $this->tryEditGet($this->controller);

        $this->tryEditPost(
            $this->controller,
            $this->validEntityData,
            1
        );
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete(): void
    {
        $this->tryDeletePost(
            $this->controller,
            $this->validEntityData,
            8
        );
    }
}

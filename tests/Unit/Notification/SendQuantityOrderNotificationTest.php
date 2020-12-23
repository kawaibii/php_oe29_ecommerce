<?php

namespace Tests\Unit\Notification;

use App\Notifications\SendQuantityOrderNotification;
use Tests\TestCase;

class SendQuantityOrderNotificationTest extends TestCase
{
    protected $sendQuantity, $data;

    public function setUp(): void
    {
        parent::setUp();
        $this->data = [
            'message' => 123,
            'route' => route('orders.index'),
        ];
        $this->sendQuantity = new SendQuantityOrderNotification($this->data);
    }

    public function tearDown(): void
    {
        unset($this->data);
        unset($this->sendQuantity);
        parent::tearDown();
    }

    public function test_via_method()
    {
        $this->assertEquals(['mail'], $this->sendQuantity->via($this->data));
    }

    public function test_toMail_method()
    {
        $this->assertEquals("emails.send_email_quantity_order_pending", $this->sendQuantity->toMail($this->data)->markdown);
        $this->assertEquals($this->data, $this->sendQuantity->toMail($this->data)->viewData['data']);
    }
}

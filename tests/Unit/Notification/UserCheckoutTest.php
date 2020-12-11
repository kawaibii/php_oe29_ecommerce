<?php

namespace Tests\Unit\Notification;

use App\Notifications\UserCheckoutNotification;
use Tests\TestCase;

class UserCheckoutTest extends TestCase
{
   protected $userCheckout, $data;

    public function setUp(): void
    {
        parent::setUp();
        $this->data = [
            'message' => "message_pending",
            'name_user' => "ssssss",
            'order_id' => "123",
        ];
        $this->userCheckout = new UserCheckoutNotification($this->data);
        $this->data['id'] = $this->userCheckout->id;

    }


    public function tearDown(): void
    {
        unset($this->UserCheckout);
        parent::tearDown();
    }

    public function test_via_method()
    {
        $this->assertEquals(['database'], $this->userCheckout->via($this->data));
    }

    public function test_to_array()
    {
        $this->assertEquals($this->data, $this->userCheckout->toArray($this->data));
    }
}

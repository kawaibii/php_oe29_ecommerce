<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Notification;
use App\Models\User;
use Faker\Generator as Faker;

class NotificationTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    protected $notification, $user;

    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function setUp(): void
    {
        $this->user = new User(['id' => 1]);
        $this->notification = new Notification([
            'notifiable_id' => 1,
            'notifiable_type' => "App\Models\User",
        ]);
        parent::setUp();
    }

    public function tearDown(): void
    {
        unset($this->notification);
        parent::tearDown();
    }

    public function test_valid_fillable_properties()
    {
        $data = [
            'read_at',
            'notifiable_id',
            'notifiable_type',
        ];
        $this->assertEquals($data, $this->notification->getFillable());
    }

    public function test_valid_name_table()
    {
        $this->assertEquals('notifications', $this->notification->getTable());
    }

    public function test_primary_key_propoertires()
    {
        $this->assertEquals('id', $this->notification->getKeyName());
    }

    public function test_date_properties()
    {
        $this->assertEquals(['created_at', 'updated_at'], $this->notification->getDates());
    }

    public function test_method_notifiable()
    {
        $this->assertInstanceOf(User::class, $this->notification->notifiable);
    }
}

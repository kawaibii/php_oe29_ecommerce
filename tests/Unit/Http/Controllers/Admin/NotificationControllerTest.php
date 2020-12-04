<?php

namespace Tests\Unit\Http\Controllers\Admin;

use App\Http\Controllers\Admin\NotificationController;
use App\Models\Order;
use App\Models\User;
use App\Models\Notification;
use App\Repositories\Notification\NotificationRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Service\FirebaseService;
use Tests\TestCase;
use Mockery;

class NotificationControllerTest extends TestCase
{
    protected $orderMock, $notificationMock;
    protected $notificationController, $user, $firebase;

    public function setUp(): void
    {
        parent::setUp();
        $this->orderMock = Mockery::mock(OrderRepositoryInterface::class)->makePartial();
        $this->notificationMock = Mockery::mock(NotificationRepositoryInterface::class)->makePartial();
        $this->firebase = Mockery::mock(FirebaseService::class)->makePartial();
        $this->user = new User([
            'id' => 123,
            'name' => 'le khoan',
            'address' => 'ha noi',
            'phone' => '123456789',
            'email' => 'abc@gmail.com',
            'password' => bcrypt('123456'),
            'status' => 1,
            'role_id' => config('role.admin.management'),
        ]);
        $this->be($this->user);
        $this->notificationController = new NotificationController($this->notificationMock, $this->orderMock, $this->firebase);
    }

    public function tearDown(): void
    {
        Mockery::close();
        unset($this->notificationController);
        parent::tearDown();
    }

    public function test_method_showDetailOrder()
    {
        $data = [
            "id" => "6bd0db0d-5be5-488a-8980-ed6cb963e2ea",
            "message" => "message_pending",
            "name_user" => "Admin",
            "order_id"=> 5,
        ];
        $order = factory(Order::class)->make();
        $notification = new Notification($data);
        $notification->data = json_encode($data);
        $notification->id = "6bd0db0d-5be5-488a-8980-ed6cb963e2ea";
        $notification->setRelation('notifiable', $this->user);
        $this->notificationMock->shouldReceive('find')
            ->with($notification->id)
            ->once()
            ->andReturn($notification);
        $this->notificationMock->shouldReceive('update')
            ->andReturn(true);
        $this->firebase->shouldReceive('updateNotificationOrder')
            ->andReturn(true);
        $this->orderMock->shouldReceive('find')->andReturn(true);
        $this->orderMock->shouldReceive('orderBy')->andReturn(true);
        $response = $this->notificationController->showDetailOrder("6bd0db0d-5be5-488a-8980-ed6cb963e2ea");
        $this->assertEquals('admin.orders.index', $response->getName());
        $this->assertArrayHasKey('detailOrder', $response->getData());
        $this->assertArrayHasKey('orders', $response->getData());
    }

    public function test_method_showDetailOrder_not_match_notification()
    {
       $route = route('products.index');
        $this->notificationMock->shouldReceive('find')
            ->with("12312323521341231231231f")
            ->once()
            ->andReturn(false);
        $result = $this->from($route)->notificationController->showDetailOrder("12312323521341231231231f");
        $this->assertEquals($route, $result->getTargetUrl());
    }
}

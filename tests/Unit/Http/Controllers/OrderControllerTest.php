<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\OrderController;
use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\Models\User;
use App\Notifications\UserCheckoutNotification;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Service\FirebaseService;
use Mockery;
use Tests\TestCase;
use Session;
use Illuminate\Support\Facades\Notification;
use Illuminate\Database\Eloquent\Collection;

class OrderControllerTest extends TestCase
{
    protected $orderRepo, $productRepo, $userRepo, $orderController, $user;
    protected $order, $firebase;

    public function setUp(): void
    {
        parent::setUp();
        $this->orderRepo = Mockery::mock(OrderRepositoryInterface::class)->makePartial();
        $this->userRepo = Mockery::mock(UserRepositoryInterface::class)->makePartial();
        $this->productRepo = Mockery::mock(ProductRepositoryInterface::class)->makePartial();
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
        Session::put('cart', [
            [
                'product_detail_id' => "123",
                'product_id' => '1',
                'size' => 3,
                'quantity' => (int) 3,
                'price' => (int) 150000,
            ],
        ]);
        $this->be($this->user);
        $this->user->id =123;
        $this->order = factory(Order::class)->make();
        $this->orderController = new OrderController($this->orderRepo, $this->productRepo, $this->userRepo, $this->firebase);
    }

    public function tearDown(): void
    {
        Mockery::close();
        unset($this->orderController);
        parent::tearDown();
    }

    public function test_checkout_method()
    {
        $data = [
            'payment' => 123124123,
            'receive_address' => "yen bai",
            'receive_phone' => "12345678",
            'note' => "1234 54312",
        ];
        $request = new CheckoutRequest($data);
        $this->orderRepo->shouldReceive('create')
            ->once()
            ->andReturn($this->order);
        $this->orderRepo->shouldReceive('attach')
            ->once()
            ->andReturn(true);
        Notification::fake();
        $notifcation1 = new UserCheckoutNotification($data);
        $notifcation2 = new UserCheckoutNotification($data);
        $notifcation2->id =2;
        $notifcation1->id =1;
        $notifcations = new Collection([$notifcation1, $notifcation2]);
        $this->user->setRelation('notifications', $notifcations);
        $this->firebase->shouldReceive('sendNotificationOrderPending')->andReturn(true);
        $reponse = $this->orderController->checkout($request);
        Notification::assertSentTo(
            $this->user,
            UserCheckoutNotification::class
        );
        $this->assertEquals(route('user.orderHistory'), $reponse->getTargetUrl());
    }

    public function test_checkout_method_not_sendNotification()
    {
        $data = [
            'payment' => 123124123,
            'receive_address' => "yen bai",
            'receive_phone' => "12345678",
            'note' => "1234 54312",
        ];
        $request = new CheckoutRequest($data);
        $this->orderRepo->shouldReceive('create')
            ->once()
            ->andReturn($this->order);
        $this->orderRepo->shouldReceive('attach')
            ->once()
            ->andReturn(true);
        Notification::fake();
        $notifcation1 = new UserCheckoutNotification($data);
        $notifcation2 = new UserCheckoutNotification($data);
        $notifcation2->id =2;
        $notifcation1->id =1;
        $notifcations = new Collection([$notifcation1, $notifcation2]);
        $this->user->setRelation('notifications', $notifcations);
        $this->firebase->shouldReceive('sendNotificationOrderPending')->andReturn(true);
        Notification::assertNotSentTo(
            $this->user,
            UserCheckoutNotification::class
        );
        $reponse = $this->orderController->checkout($request);
    }
}

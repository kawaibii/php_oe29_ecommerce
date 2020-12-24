<?php

namespace Tests\Unit\Commands;

use App\Console\Commands\ReportOrderPendingCommand;
use App\Jobs\SendEmail;
use App\Models\User;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;
use Mockery;
use Illuminate\Support\Collection;

class ReportOrderPendingTest extends TestCase
{
    protected $orderMock, $userMock, $reportOrder;

    public function setUp(): void
    {
        parent::setUp();
        $this->orderMock = Mockery::mock(OrderRepositoryInterface::class)->makePartial();
        $this->userMock = Mockery::mock(UserRepositoryInterface::class)->makePartial();
        $this->reportOrder = new ReportOrderPendingCommand($this->orderMock, $this->userMock);
    }

    public function tearDown(): void
    {
        Mockery::close();
        unset($this->reportOrder);
        parent::tearDown();
    }

    public function test_valid_signature_property()
    {
        $this->assertEquals('report:order_pending', $this->reportOrder->getName());
    }

    public function test_valid_description_property()
    {
        $this->assertEquals('Thông báo 16h hàng ngày các đơn hàng còn pending', $this->reportOrder->getDescription());
    }

    public function test_method_handle()
    {
        $user = factory(User::class)->make();
        $user->role_id = config('role.admin.management');
        $user1 = factory(User::class)->make();
        $user1->role_id = config('role.admin.management');
        $users = new Collection([$user1, $user]);
        $this->orderMock->shouldReceive('quantityOrderByStatus')
            ->once()
            ->andReturn(3);
        $data = [
            [
                'role_id', config('role.admin.management'),
            ],
        ];
        $this->userMock->shouldReceive('where')
            ->once()
            ->withAnyArgs($data)
            ->andReturn($users);
        Bus::fake();
        $this->reportOrder->handle();
        Bus::assertDispatched(SendEmail::class);
    }
}

<?php

namespace App\Console\Commands;

use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Console\Command;
use App\Notifications\SendQuantityOrderNotification;
use Illuminate\Support\Facades\Auth;
use App;

class ReportOrderPendingCommand extends Command
{

    protected $orderRepo, $userRepo;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:order_pending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Thông báo 16h hàng ngày các đơn hàng còn pending';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(OrderRepositoryInterface $order, UserRepositoryInterface $user)
    {
        $this->orderRepo = $order;
        $this->userRepo = $user;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $countOrderPending = $this->orderRepo->quantityOrderByStatus();
        $data = [
            'message' => $countOrderPending,
            'route' => route('orders.index'),
        ];
        $users = $this->userRepo->getALl();
        foreach ($users->where('role_id', config('role.admin.management')) as $user) {
            $user->notify(new SendQuantityOrderNotification($data));
        }
    }
}

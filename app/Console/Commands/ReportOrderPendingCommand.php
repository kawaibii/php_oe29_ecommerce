<?php

namespace App\Console\Commands;

use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Jobs\SendEmail;

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
        Carbon::setLocale('vi');
        $data = [
            'quantity' => $countOrderPending,
            'route' => route('orders.index'),
            'time' => Carbon::now()->toDateString(),
        ];
        $users = $this->userRepo->where([['role_id', config('role.admin.management')]]);
        if (!empty($users)) {
            foreach ($users as $user) {
                $data['username'] = $user->name;
                SendEmail::dispatch($data, $user);
            }
        }
    }
}

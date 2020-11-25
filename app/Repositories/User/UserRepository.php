<?php

namespace App\Repositories\User;
use App\Models\User;

use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    public function getModel()
    {
        return User::class;
    }

    public function getOrderHistory($id)
    {
        $user = User::find($id);
        if ($user) {
            return $user->orders()
                ->orderBy('created_at', 'desc')
                ->with(['productDetails.product' => function ($query) {
                    $query->withTrashed();
                }])
                ->paginate(config('setting.paginate.order'));
        }

        return false;
    }
}

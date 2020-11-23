<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class NotificationController extends Controller
{
    public function read($id)
    {
        $notification = DB::table('notifications')->where('id', $id)->first();
        if ($notification->read_at == null) {
            DB::table('notifications')->where('id', $id)->update([
                'read_at' => Carbon::now(),
            ]);
        }

        return redirect()->route('user.orderHistory');
    }
}

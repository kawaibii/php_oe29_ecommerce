<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'read_at',
        'notifiable_id',
        'notifiable_type',
    ];

    protected $table = "notifications";

    public function notifiable()
    {
        return $this->morphTo();
    }
}

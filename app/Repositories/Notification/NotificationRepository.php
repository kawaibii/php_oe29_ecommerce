<?php

namespace App\Repositories\Notification;

use App\Models\Notification;
use App\Notifications\UserCheckoutNotification;
use App\Repositories\BaseRepository;

class NotificationRepository extends BaseRepository implements NotificationRepositoryInterface
{

    public function getModel()
    {
        return Notification::class;
    }

    public function getNotificationPending()
    {
        return Notification::orderBy('created_at', 'DESC')->where('type', UserCheckoutNotification::class)->get();
    }
}

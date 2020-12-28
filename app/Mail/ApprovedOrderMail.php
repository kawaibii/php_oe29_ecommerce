<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApprovedOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject(trans('email.approved_order.subject'))
            ->markdown('emails.approved_order')
            ->with([
                'name' => $this->data['name'],
                'order' => $this->data['order'],
                'itemInOrder' => $this->data['itemInOrder'],
            ]);
    }
}

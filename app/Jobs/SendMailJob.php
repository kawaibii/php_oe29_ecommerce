<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;
use App\Mail\ApprovedOrderMail;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function handle()
    {
        $dataToMail = [
            'name' => $this->data['name'],
            'order' => $this->data['order'],
            'itemInOrder' => $this->data['itemInOrder'],
        ];
        Mail::to($this->data['email'])->send(new ApprovedOrderMail($dataToMail));
    }
}

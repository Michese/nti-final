<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DriverOrderStart extends Mailable
{
    use Queueable, SerializesModels;

    private User $toDriver;
    private Order $order;

    public function __construct(User $toDriver, Order $order)
    {
        $this->toDriver = $toDriver;
        $this->order = $order;
    }

    public function build()
    {
        return $this->from('example@example.com')
            ->view('mail.driverOrderStart')
            ->with([
                'user' => $this->toDriver,
                'order' => $this->order
            ])
            ->to($this->toDriver->email);
    }
}

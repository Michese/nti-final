<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientOrderEnd extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(User $toUser)
    {
        $this->toUser = $toUser;
    }

    private User $toUser;

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('example@example.com')
            ->view('mail.clientOrderEnd')
            ->with(['user' => $this->toUser])
            ->to($this->toUser->email);
    }
}

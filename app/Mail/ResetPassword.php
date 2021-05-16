<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\Email;

class ResetPassword extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $email;

    /**
     * Create a new message instance.
     * @param App\Models\Email $email
     * @return void
     */
    public function __construct(Email $email)
    {
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@myinventory.app')
                    ->subject('My Inventory | Reset Password')
                    ->markdown('mail.password_reset')
                    ->with([
                        'email' => $this->email,
                    ]);
    }
}

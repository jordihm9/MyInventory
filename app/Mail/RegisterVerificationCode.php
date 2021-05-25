<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterVerificationCode extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    
    private $verification_code;
    
    /**
     * Create a new message instance.
     * @param App\Models\Email $email
     * @return void
     */
    public function __construct($verification_code)
    {
        $this->verification_code = $verification_code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@myinventory.link')
                    ->subject('My Inventory | Registration Verification Code')
                    ->markdown('mail.registration')
                    ->with([
                        'verification_code' => $this->verification_code
                    ]);
    }
}

<?php

namespace BajakLautMalaka\PmiAdmin\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPasswordRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $resetToken;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($resetToken)
    {
        $this->resetToken = $resetToken;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('admin@pmidkijakarta.or.id')->view('admin::emails.admin.request-password-reset');
    }
}

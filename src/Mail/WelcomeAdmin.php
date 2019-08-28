<?php

namespace BajakLautMalaka\PmiAdmin\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeAdmin extends Mailable
{
    use Queueable, SerializesModels;
    
    public $admin;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($admin)
    {
        $this->admin = $admin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $admin      = $this->admin;
        $site_url   = 'http://webui-develop-pmi-public.blm.solutions/';
        return $this->from('admin@pmidkijakarta.or.id')->view('admin::emails.admin.mail-registrasi-admin',compact('admin','site_url'));
    }
}

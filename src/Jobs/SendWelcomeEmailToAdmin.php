<?php

namespace BajakLautMalaka\PmiAdmin\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use BajakLautMalaka\PmiAdmin\Mail\WelcomeAdmin;

class SendWelcomeEmailToAdmin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $newAdmin;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($newAdmin)
    {
        $this->newAdmin = $newAdmin;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->newAdmin->email)->send(new WelcomeAdmin($this->newAdmin));
    }
}

<?php

namespace BajakLautMalaka\PmiAdmin\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use BajakLautMalaka\PmiAdmin\Mail\ResetPasswordRequest;

class SendResetPasswordEmailToAdmin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $resetToken = Str::uuid();
        
        DB::table('password_resets')->insert([
            'email'=>$this->email,
            'token'=>$resetToken,
            'created_at'=> Carbon::now()
        ]);
        
        Mail::to($this->email)->send(new ResetPasswordRequest($resetToken));
    }
}

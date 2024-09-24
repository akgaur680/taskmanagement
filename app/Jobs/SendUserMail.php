<?php

namespace App\Jobs;

use App\Mail\UserMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendUserMail implements ShouldQueue
{
    use Queueable;

    public $user;
    public $subject;
    public $email;

    /**
     * Create a new job instance.
     */
    public function __construct($user, $subject, $email)
    {
        $this->user = $user;
        $this->subject = $subject;
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)->queue(new UserMail($this->user, $this->subject, $this->email));
        
    }
}

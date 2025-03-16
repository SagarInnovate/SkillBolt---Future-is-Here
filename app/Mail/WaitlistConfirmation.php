<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Waitlist;
use Illuminate\Support\Str;

class WaitlistConfirmation extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $waitlist;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Waitlist $waitlist)
    {
        $this->waitlist = $waitlist;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Generate a temporary referral code if user doesn't have one yet
        // In real implementation, you would create this properly
        if (!isset($this->waitlist->referral_code)) {
            $this->waitlist->referral_code = strtoupper(Str::random(8));
        }
        
        return $this->subject('Welcome to SkillBolt.dev Waitlist!')
                    ->view('emails.waitlist-confirmation');
    }
}
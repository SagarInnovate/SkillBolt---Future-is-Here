<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;
use App\Models\Referral;
use App\Models\AffiliateSetting;

class ReferralConfirmed extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $referrer;
    public $referral;
    public $commissionRate;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $referrer, Referral $referral)
    {
        $this->referrer = $referrer;
        $this->referral = $referral;
        $this->commissionRate = AffiliateSetting::get('commission_rate', 300);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('SkillBolt.dev - New Referral Confirmed!')
                    ->view('emails.referral-confirmed');
    }
}
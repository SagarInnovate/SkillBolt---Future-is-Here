<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Commission;
use App\Models\AffiliateSetting;

class CommissionApproved extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $commission;
    public $minPayoutThreshold;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Commission $commission)
    {
        $this->commission = $commission;
        $this->minPayoutThreshold = AffiliateSetting::get('min_payout_threshold', 1000);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('SkillBolt.dev - Commission Approved!')
                    ->view('emails.commission-approved');
    }
}
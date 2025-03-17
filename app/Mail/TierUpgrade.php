<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;
use App\Models\AffiliateSetting;

class TierUpgrade extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $newTier;
    public $baseCommission;
    public $tierBonus;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, int $newTier)
    {
        $this->user = $user;
        $this->newTier = $newTier;
        
        // Get commission rates
        $this->baseCommission = AffiliateSetting::get('commission_rate', 300);
        
        // Get tier bonus from settings
        $tierRequirements = AffiliateSetting::get('tier_requirements', []);
        $this->tierBonus = $tierRequirements[$newTier]['bonus'] ?? 0;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('SkillBolt.dev - You\'ve Been Upgraded to Tier ' . $this->newTier)
                    ->view('emails.tier-upgrade');
    }
}
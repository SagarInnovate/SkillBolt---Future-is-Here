<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\AffiliateSetting;

class TierUpgrade extends Notification implements ShouldQueue
{
    use Queueable;

    protected $newTier;
    protected $baseCommission;
    protected $tierBonus;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(int $newTier)
    {
        $this->newTier = $newTier;
        
        // Get commission rates
        $this->baseCommission = AffiliateSetting::get('commission_rate', 300);
        
        // Get tier bonus from settings
        $tierRequirements = AffiliateSetting::get('tier_requirements', []);
        $this->tierBonus = $tierRequirements[$newTier]['bonus'] ?? 0;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('SkillBolt.dev - You\'ve Been Upgraded to Tier ' . $this->newTier)
                    ->view('emails.tier-upgrade', [
                        'user' => $notifiable,
                        'newTier' => $this->newTier,
                        'baseCommission' => $this->baseCommission,
                        'tierBonus' => $this->tierBonus
                    ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'tier' => $this->newTier,
            'base_commission' => $this->baseCommission,
            'tier_bonus' => $this->tierBonus,
            'message' => 'You\'ve been upgraded to Tier ' . $this->newTier . '!',
            'type' => 'tier_upgrade'
        ];
    }
}
<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Referral;
use App\Models\AffiliateSetting;

class ReferralConfirmed extends Notification implements ShouldQueue
{
    use Queueable;

    protected $referral;
    protected $commissionRate;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Referral $referral)
    {
        $this->referral = $referral;
        $this->commissionRate = AffiliateSetting::get('commission_rate', 300);
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
                    ->subject('SkillBolt.dev - New Referral Confirmed!')
                    ->view('emails.referral-confirmed', [
                        'referrer' => $notifiable,
                        'referral' => $this->referral,
                        'commissionRate' => $this->commissionRate
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
            'referral_id' => $this->referral->id,
            'referred_user_id' => $this->referral->referred_user_id,
            'referred_user_name' => $this->referral->referredUser->name,
            'message' => 'New referral confirmed: ' . $this->referral->referredUser->name,
            'type' => 'referral_confirmed'
        ];
    }
}
<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Commission;
use App\Models\AffiliateSetting;

class CommissionApproved extends Notification implements ShouldQueue
{
    use Queueable;

    protected $commission;
    protected $minPayoutThreshold;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Commission $commission)
    {
        $this->commission = $commission;
        $this->minPayoutThreshold = AffiliateSetting::get('min_payout_threshold', 1000);
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
                    ->subject('SkillBolt.dev - Commission Approved!')
                    ->view('emails.commission-approved', [
                        'commission' => $this->commission,
                        'minPayoutThreshold' => $this->minPayoutThreshold
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
            'commission_id' => $this->commission->id,
            'amount' => $this->commission->amount,
            'referral_id' => $this->commission->referral_id,
            'message' => 'Commission approved: ₹' . number_format($this->commission->amount, 2),
            'type' => 'commission_approved'
        ];
    }
}
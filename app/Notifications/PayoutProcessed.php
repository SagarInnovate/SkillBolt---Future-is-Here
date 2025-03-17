<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Payout;

class PayoutProcessed extends Notification implements ShouldQueue
{
    use Queueable;

    protected $payout;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Payout $payout)
    {
        $this->payout = $payout;
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
                    ->subject('SkillBolt.dev - Payout Processed!')
                    ->view('emails.payout-processed', [
                        'payout' => $this->payout
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
            'payout_id' => $this->payout->id,
            'amount' => $this->payout->amount,
            'transaction_id' => $this->payout->transaction_id,
            'status' => $this->payout->status,
            'message' => 'Payout processed: ₹' . number_format($this->payout->amount, 2),
            'type' => 'payout_processed'
        ];
    }
}
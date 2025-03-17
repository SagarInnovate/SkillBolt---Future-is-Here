<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Achievement;

class AchievementEarned extends Notification implements ShouldQueue
{
    use Queueable;

    protected $achievement;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Achievement $achievement)
    {
        $this->achievement = $achievement;
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
                    ->subject('SkillBolt.dev - Achievement Unlocked!')
                    ->view('emails.achievement-earned', [
                        'user' => $notifiable,
                        'achievement' => $this->achievement
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
            'achievement_id' => $this->achievement->id,
            'achievement_name' => $this->achievement->name,
            'points_value' => $this->achievement->points_value,
            'message' => 'Achievement unlocked: ' . $this->achievement->name,
            'type' => 'achievement_earned'
        ];
    }
}
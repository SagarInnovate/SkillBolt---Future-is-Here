<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;
use App\Models\Achievement;

class AchievementEarned extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $achievement;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Achievement $achievement)
    {
        $this->user = $user;
        $this->achievement = $achievement;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('SkillBolt.dev - Achievement Unlocked!')
                    ->view('emails.achievement-earned');
    }
}

<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BalanceDiscrepancyAlert extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $storedBalance;
    public $calculatedBalance;

    public function __construct(User $user, $storedBalance, $calculatedBalance)
    {
        $this->user = $user;
        $this->storedBalance = $storedBalance;
        $this->calculatedBalance = $calculatedBalance;
    }

    public function build()
    {
        return $this->subject('URGENT: Balance Discrepancy Detected')
                    ->markdown('emails.balance-discrepancy-alert');
    }
}
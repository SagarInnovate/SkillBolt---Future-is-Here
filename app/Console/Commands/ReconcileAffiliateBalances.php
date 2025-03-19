<?php

namespace App\Console\Commands;

use App\Models\AffiliateDetail;
use App\Models\SecureTransaction;
use App\Models\AuditLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\BalanceDiscrepancyAlert;

class ReconcileAffiliateBalances extends Command
{
    protected $signature = 'affiliate:reconcile';
    protected $description = 'Reconcile affiliate balances with transaction history';

    public function handle()
    {
        $this->info('Starting balance reconciliation...');
        
        $affiliateDetails = AffiliateDetail::all();
        $discrepancies = 0;
        
        foreach ($affiliateDetails as $detail) {
            $storedBalance = $detail->available_balance;
            $calculatedBalance = $detail->calculated_balance;
            
            // Check for discrepancies (using bccomp for precise decimal comparison)
            if (bccomp((string) $storedBalance, (string) $calculatedBalance, 2) !== 0) {
                $discrepancies++;
                
                $this->warn("Discrepancy found for user #{$detail->user_id}: Stored: {$storedBalance}, Calculated: {$calculatedBalance}");
                
                // Log the discrepancy
                AuditLog::create([
                    'user_id' => null,
                    'action' => 'balance_discrepancy_detected',
                    'details' => json_encode([
                        'user_id' => $detail->user_id,
                        'stored_balance' => (string) $storedBalance,
                        'calculated_balance' => (string) $calculatedBalance,
                        'difference' => (string) ($calculatedBalance - $storedBalance)
                    ])
                ]);
                
                // Alert administrators
                if (config('mail.admin_address')) {
                    Mail::to(config('mail.admin_address'))->send(
                        new BalanceDiscrepancyAlert($detail->user, $storedBalance, $calculatedBalance)
                    );
                }
                
                // Optionally auto-correct the balance
                // Uncomment if you want automatic correction:
                /*
                $detail->available_balance = $calculatedBalance;
                $detail->save();
                
                AuditLog::create([
                    'user_id' => null,
                    'action' => 'balance_auto_corrected',
                    'details' => json_encode([
                        'user_id' => $detail->user_id,
                        'old_balance' => (string) $storedBalance,
                        'new_balance' => (string) $calculatedBalance
                    ])
                ]);
                */
            }
            
            // Update reconciliation timestamp
            $detail->last_reconciled_at = now();
            $detail->save();
        }
        
        $this->info("Reconciliation complete. Found {$discrepancies} discrepancies.");
        
        return Command::SUCCESS;
    }
}
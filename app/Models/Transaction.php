<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'transaction_code',
        'user_id',
        'transaction_type',
        'amount',
        'currency',
        'type',
        'status',
        'balance_after',
        'description',
        'metadata',
    ];
    
    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'balance_after' => 'decimal:2',
        'metadata' => 'json',
        'is_locked' => 'boolean',
        'last_verified_at' => 'datetime',
    ];
    
    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        static::creating(function ($transaction) {
            // Generate a unique transaction code if not provided
            if (empty($transaction->transaction_code)) {
                $transaction->transaction_code = static::generateUniqueCode();
            }
            
            // Generate signature for transaction integrity
            if (empty($transaction->signature)) {
                $transaction->signature = self::generateSignature($transaction);
            }
            
            // Set default for is_locked if not provided
            if (!isset($transaction->is_locked)) {
                $transaction->is_locked = true;
            }
        });
        
        // Prevent updates to financial fields if the transaction is locked
        static::updating(function ($transaction) {
            if ($transaction->is_locked) {
                $protectedFields = [
                    'transaction_code', 'user_id', 'amount', 'type', 
                    'status', 'balance_after', 'signature'
                ];
                
                $dirtyFields = array_keys($transaction->getDirty());
                
                foreach ($dirtyFields as $field) {
                    if (in_array($field, $protectedFields)) {
                        if ($field === 'status' && auth()->user() && auth()->user()->isAdmin()) {
                            // Allow status changes by admins (with audit log)
                            if (class_exists('App\Models\AuditLog')) {
                                AuditLog::create([
                                    'user_id' => auth()->id(),
                                    'action' => 'transaction_status_changed',
                                    'details' => json_encode([
                                        'transaction_id' => $transaction->id,
                                        'old_status' => $transaction->getOriginal('status'),
                                        'new_status' => $transaction->status
                                    ]),
                                    'ip_address' => request()->ip(),
                                    'user_agent' => request()->userAgent()
                                ]);
                            }
                            continue;
                        }
                        
                        // Prevent update of protected fields
                        return false;
                    }
                }
            }
        });
    }
    
    /**
     * Generate a unique transaction code.
     */
    public static function generateUniqueCode(): string
    {
        do {
            $code = 'TXN-' . strtoupper(Str::random(10));
        } while (static::where('transaction_code', $code)->exists());
        
        return $code;
    }
    
    /**
     * Generate signature for transaction verification.
     */
    public static function generateSignature($transaction): string
    {
        $data = json_encode([
            'transaction_code' => $transaction->transaction_code,
            'user_id' => $transaction->user_id,
            'amount' => (string) $transaction->amount,
            'type' => $transaction->type,
            'transaction_type' => $transaction->transaction_type,
            'created_at' => $transaction->created_at ? $transaction->created_at->toISOString() : now()->toISOString()
        ]);
        
        return hash_hmac('sha256', $data, config('app.key'));
    }
    
    /**
     * Verify transaction integrity.
     */
    public function verifyIntegrity(): bool
    {
        $expectedSignature = self::generateSignature($this);
        $result = hash_equals($this->signature, $expectedSignature);
        
        if ($result) {
            $this->last_verified_at = now();
            $this->saveQuietly(); // Save without triggering events
        }
        
        return $result;
    }
    
    /**
     * Get the user that owns the transaction.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the reference model (polymorphic relation).
     */
    public function reference(): MorphTo
    {
        return $this->morphTo();
    }
    
    /**
     * Scope a query to only include transactions of a specific type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('transaction_type', $type);
    }
    
    /**
     * Scope a query to only include credit transactions.
     */
    public function scopeCredits($query)
    {
        return $query->where('type', 'credit');
    }
    
    /**
     * Scope a query to only include debit transactions.
     */
    public function scopeDebits($query)
    {
        return $query->where('type', 'debit');
    }
    
    /**
     * Scope a query to only include successful/completed transactions.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
    
    /**
     * Scope a query to only include pending transactions.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
    
    /**
     * Get the transaction amount with sign based on type.
     */
    public function getSignedAmountAttribute(): string
    {
        $sign = $this->type === 'credit' ? '+' : '-';
        return $sign . $this->amount;
    }
    
    /**
     * Get the formatted amount with currency.
     */
    public function getFormattedAmountAttribute(): string
    {
        $sign = $this->type === 'credit' ? '+' : '-';
        $currency = $this->currency ?? 'INR';
        
        if ($currency === 'INR') {
            return $sign . '₹' . number_format($this->amount, 2);
        }
        
        return $sign . $this->amount . ' ' . $currency;
    }
    
    /**
     * Get a badge class based on transaction type.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'completed' => 'bg-green-100 text-green-800',
            'pending' => 'bg-yellow-100 text-yellow-800',
            'failed' => 'bg-red-100 text-red-800',
            'reversed' => 'bg-gray-100 text-gray-800',
            default => 'bg-blue-100 text-blue-800',
        };
    }
    
    /**
     * Get a badge class based on transaction type.
     */
    public function getTypeBadgeClassAttribute(): string
    {
        return $this->type === 'credit' 
            ? 'bg-green-100 text-green-800' 
            : 'bg-red-100 text-red-800';
    }
    
    /**
     * Calculate a user's current balance from transaction history.
     */
/**
 * Calculate a user's current balance from transaction history.
 */

 public static function calculateUserBalance($userId): float
 {
     // Define transaction types that increase balance
     $creditTypes = [
         'commission',           // Affiliate commissions
         'sales_earnings',       // Seller earnings
         'refund_received',      // Refunds received
         'bonus',                // Bonuses awarded
         'deposit',              // Manual deposits
         'subscription_refund'   // Refunded subscription
     ];
     
     // Define transaction types that decrease balance
     $debitTypes = [
         'payout',               // Affiliate/seller payouts
         'purchase',             // Project purchases
         'subscription',         // Subscription payments
         'mentor_fee',           // Mentor service fees
         'freelance_payment',    // Freelance payments
         'custom_project_payment' // Custom project payments
     ];
 
     // Get all transactions for the user
     $transactions = self::where('user_id', $userId)
         ->where('status', 'completed')
         ->get();
 
     // Filter transactions with valid integrity
     $validTransactions = $transactions->filter(function($transaction) {
         return $transaction->verifyIntegrity();
     });
     
     // Calculate credits - use collection methods, not query builder
     $credits = $validTransactions->filter(function($transaction) use ($creditTypes) {
         return $transaction->type === 'credit' && in_array($transaction->transaction_type, $creditTypes);
     })->sum('amount');
     
     // Calculate debits - use collection methods, not query builder
     $debits = $validTransactions->filter(function($transaction) use ($debitTypes) {
         return $transaction->type === 'debit' && in_array($transaction->transaction_type, $debitTypes);
     })->sum('amount');
     
     return floatval($credits - $debits);
 }
    
    /**
     * Create a transaction record with signature and auditing.
     *
     * @param int $userId User ID
     * @param string $transactionType Type of transaction (purchase, commission, etc.)
     * @param float $amount Transaction amount
     * @param string $type Whether this is a credit or debit
     * @param string|null $description Description of the transaction
     * @param Model|null $reference Related model instance
     * @param array|null $metadata Additional metadata
     * @param string $currency Currency code (default: INR)
     * @param string $status Transaction status (default: completed)
     * @return self
     */
    public static function createTransaction(
        $userId, 
        $transactionType, 
        $amount, 
        $type, 
        $description = null, 
        $reference = null, 
        $metadata = null,
        $currency = 'INR',
        $status = 'completed'
    ): self {
        // Calculate balance from transaction history for accuracy
        $currentBalance = self::calculateUserBalance($userId);
        
        // Calculate new balance
        $balanceAfter = $type === 'credit' 
            ? $currentBalance + $amount 
            : $currentBalance - $amount;
            
        // Create transaction
        $transaction = new self();
        $transaction->transaction_code = self::generateUniqueCode();
        $transaction->user_id = $userId;
        $transaction->transaction_type = $transactionType;
        $transaction->amount = $amount;
        $transaction->currency = $currency;
        $transaction->type = $type;
        $transaction->status = $status;
        $transaction->balance_after = $balanceAfter;
        $transaction->description = $description;
        $transaction->is_locked = true;
        
        // If reference is provided
        if ($reference) {
            $transaction->reference()->associate($reference);
        }
        
        // If metadata is provided
        if ($metadata) {
            $transaction->metadata = $metadata;
        }
        
        // Generate signature before saving
        $transaction->signature = self::generateSignature($transaction);
        $transaction->save();
        
        // Log the transaction creation if AuditLog exists
        if (class_exists('App\Models\AuditLog')) {
            AuditLog::create([
                'user_id' => auth()->id() ?? null,
                'action' => 'transaction_created',
                'details' => json_encode([
                    'transaction_id' => $transaction->id,
                    'user_id' => $userId,
                    'amount' => (string) $amount,
                    'type' => $type,
                    'balance_after' => (string) $balanceAfter
                ]),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent()
            ]);
        }
        
        return $transaction;
    }
    
    /**
     * Mark a transaction as failed.
     */
    public function markAsFailed($reason = null): self
    {
        // Only allow if transaction is pending
        if ($this->status !== 'pending') {
            return $this;
        }
        
        $this->status = 'failed';
        
        if ($reason) {
            $this->metadata = array_merge($this->metadata ?? [], ['failure_reason' => $reason]);
        }
        
        // Temporarily unlock to allow status change
        $wasLocked = $this->is_locked;
        $this->is_locked = false;
        $this->save();
        $this->is_locked = $wasLocked;
        $this->save();
        
        // Log the action if AuditLog exists
        if (class_exists('App\Models\AuditLog')) {
            AuditLog::create([
                'user_id' => auth()->id() ?? null,
                'action' => 'transaction_marked_failed',
                'details' => json_encode([
                    'transaction_id' => $this->id,
                    'reason' => $reason
                ]),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent()
            ]);
        }
        
        return $this;
    }
    
    /**
     * Reverse a transaction.
     * 
     * This creates a new transaction that reverses the effect of this one.
     */
    public function reverse($reason = null): self
    {
        // Only completed transactions can be reversed
        if ($this->status !== 'completed') {
            return $this;
        }
        
        // Create a reversal transaction
        $reversalType = $this->type === 'credit' ? 'debit' : 'credit';
        
        $reversal = self::createTransaction(
            $this->user_id,
            $this->transaction_type . '_reversal',
            $this->amount,
            $reversalType,
            'Reversal of transaction ' . $this->transaction_code . ($reason ? ': ' . $reason : ''),
            $this->reference,
            array_merge($this->metadata ?? [], [
                'original_transaction_id' => $this->id,
                'original_transaction_code' => $this->transaction_code,
                'reversal_reason' => $reason
            ])
        );
        
        // Mark this transaction as reversed
        $originalMetadata = $this->metadata ?? [];
        $newMetadata = array_merge($originalMetadata, [
            'reversal_transaction_id' => $reversal->id,
            'reversal_transaction_code' => $reversal->transaction_code,
            'reversal_reason' => $reason
        ]);
        
        // Temporarily unlock to allow status change
        $wasLocked = $this->is_locked;
        $this->is_locked = false;
        $this->status = 'reversed';
        $this->metadata = $newMetadata;
        $this->save();
        $this->is_locked = $wasLocked;
        $this->save();
        
        // Log the reversal if AuditLog exists
        if (class_exists('App\Models\AuditLog')) {
            AuditLog::create([
                'user_id' => auth()->id() ?? null,
                'action' => 'transaction_reversed',
                'details' => json_encode([
                    'transaction_id' => $this->id,
                    'reversal_id' => $reversal->id,
                    'reason' => $reason
                ]),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent()
            ]);
        }
        
        return $reversal;
    }
    
    /**
     * Get a human-readable title for this transaction.
     */
    public function getReadableTitleAttribute(): string
    {
        return match($this->transaction_type) {
            'purchase' => 'Project Purchase',
            'commission' => 'Referral Commission',
            'payout' => 'Payout',
            'sales_earnings' => 'Sales Earnings',
            'subscription' => 'Subscription Payment',
            'refund' => 'Refund',
            'bonus' => 'Bonus',
            default => ucfirst(str_replace('_', ' ', $this->transaction_type)),
        };
    }
    
    /**
     * Get the icon for this transaction type.
     */
    public function getIconAttribute(): string
    {
        return match($this->transaction_type) {
            'purchase' => '<svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>',
            'commission' => '<svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>',
            'payout' => '<svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>',
            'sales_earnings' => '<svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
            'subscription' => '<svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>',
            'refund' => '<svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>',
            'bonus' => '<svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>',
            default => '<svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>',
        };
    }
}
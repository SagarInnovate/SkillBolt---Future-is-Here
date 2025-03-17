<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Achievement;
use App\Services\AffiliateService;
use Illuminate\Support\Facades\Log;

class CheckAchievements extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:achievements';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and award achievements for users';

    /**
     * The affiliate service.
     *
     * @var \App\Services\AffiliateService
     */
    protected $affiliateService;

    /**
     * Create a new command instance.
     *
     * @param  \App\Services\AffiliateService  $affiliateService
     * @return void
     */
    public function __construct(AffiliateService $affiliateService)
    {
        parent::__construct();
        $this->affiliateService = $affiliateService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Checking achievements for users...');
        
        // Get all active achievements
        $achievements = Achievement::where('is_active', true)->get();
        
        if ($achievements->isEmpty()) {
            $this->warn('No active achievements found.');
            return 0;
        }
        
        $this->info('Found ' . $achievements->count() . ' active achievements.');
        
        // Get users with affiliate accounts
        $users = User::whereHas('affiliateDetails')->get();
        
        if ($users->isEmpty()) {
            $this->warn('No users with affiliate accounts found.');
            return 0;
        }
        
        $this->info('Checking ' . $users->count() . ' users for achievements...');
        
        $awardedCount = 0;
        
        foreach ($users as $user) {
            // Skip users without affiliate details
            if (!$user->affiliateDetails) {
                continue;
            }
            
            // Check each achievement
            foreach ($achievements as $achievement) {
                // Skip if user already has this achievement
                if ($user->achievements()->where('achievement_id', $achievement->id)->exists()) {
                    continue;
                }
                
                // Check criteria
                $criteria = $achievement->criteria;
                $type = $criteria['type'] ?? '';
                $threshold = $criteria['threshold'] ?? 0;
                
                $qualified = false;
                
                switch ($type) {
                    case 'referrals':
                        $qualified = $user->affiliateDetails->successful_referrals >= $threshold;
                        break;
                        
                    case 'earnings':
                        $qualified = $user->affiliateDetails->total_earnings >= $threshold;
                        break;
                        
                    case 'tier':
                        $qualified = $user->affiliateDetails->tier_level >= $threshold;
                        break;
                        
                    case 'rank':
                        $rank = $this->affiliateService->getUserRank($user);
                        $qualified = $rank && $rank <= $threshold;
                        break;
                }
                
                if ($qualified) {
                    // Award achievement
                    $user->achievements()->attach($achievement->id, [
                        'earned_at' => now(),
                        'is_notified' => false,
                    ]);
                    
                    $awardedCount++;
                    
                    $this->info("Awarded '{$achievement->name}' to {$user->name}");
                    
                    // Log achievement
                    Log::info("Achievement awarded", [
                        'user_id' => $user->id,
                        'achievement_id' => $achievement->id,
                        'achievement_name' => $achievement->name
                    ]);
                    
                    // TODO: Send notification to user
                }
            }
        }
        
        $this->info("Awarded $awardedCount achievements.");
        
        return 0;
    }
}
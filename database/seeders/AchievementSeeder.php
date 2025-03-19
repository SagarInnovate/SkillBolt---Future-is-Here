<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $achievements = [
            [
                'name' => 'First Referral',
                'description' => 'Successfully referred your first user to SkillBolt',
                'criteria' => json_encode([
                    'type' => 'referrals',
                    'threshold' => 1,
                ]),
                'badge_image' => 'badges/first_referral.svg',
                'points_value' => 10,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Referral Pro',
                'description' => 'Successfully referred 5 users to SkillBolt',
                'criteria' => json_encode([
                    'type' => 'referrals',
                    'threshold' => 5,
                ]),
                'badge_image' => 'badges/referral_pro.svg',
                'points_value' => 25,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Referral Master',
                'description' => 'Successfully referred 15 users to SkillBolt',
                'criteria' => json_encode([
                    'type' => 'referrals',
                    'threshold' => 15,
                ]),
                'badge_image' => 'badges/referral_master.svg',
                'points_value' => 50,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Referral Champion',
                'description' => 'Successfully referred 30 users to SkillBolt',
                'criteria' => json_encode([
                    'type' => 'referrals',
                    'threshold' => 30,
                ]),
                'badge_image' => 'badges/referral_champion.svg',
                'points_value' => 100,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Referral Legend',
                'description' => 'Successfully referred 50 users to SkillBolt',
                'criteria' => json_encode([
                    'type' => 'referrals',
                    'threshold' => 50,
                ]),
                'badge_image' => 'badges/referral_legend.svg',
                'points_value' => 250,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'First Earnings',
                'description' => 'Earned your first commission from a successful referral',
                'criteria' => json_encode([
                    'type' => 'earnings',
                    'threshold' => 1,
                ]),
                'badge_image' => 'badges/first_earnings.svg',
                'points_value' => 15,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rising Earner',
                'description' => 'Earned over ₹5,000 in affiliate commissions',
                'criteria' => json_encode([
                    'type' => 'earnings',
                    'threshold' => 5000,
                ]),
                'badge_image' => 'badges/rising_earner.svg',
                'points_value' => 50,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Earning Expert',
                'description' => 'Earned over ₹25,000 in affiliate commissions',
                'criteria' => json_encode([
                    'type' => 'earnings',
                    'threshold' => 25000,
                ]),
                'badge_image' => 'badges/earning_expert.svg',
                'points_value' => 150,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Earning Master',
                'description' => 'Earned over ₹100,000 in affiliate commissions',
                'criteria' => json_encode([
                    'type' => 'earnings',
                    'threshold' => 100000,
                ]),
                'badge_image' => 'badges/earning_master.svg',
                'points_value' => 300,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Top 10',
                'description' => 'Ranked in the top 10 affiliates on the leaderboard',
                'criteria' => json_encode([
                    'type' => 'rank',
                    'threshold' => 10,
                ]),
                'badge_image' => 'badges/top_10.svg',
                'points_value' => 75,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Top 3',
                'description' => 'Ranked in the top 3 affiliates on the leaderboard',
                'criteria' => json_encode([
                    'type' => 'rank',
                    'threshold' => 3,
                ]),
                'badge_image' => 'badges/top_3.svg',
                'points_value' => 150,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Number 1',
                'description' => 'Reached the #1 position on the affiliate leaderboard',
                'criteria' => json_encode([
                    'type' => 'rank',
                    'threshold' => 1,
                ]),
                'badge_image' => 'badges/number_1.svg',
                'points_value' => 300,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tier 2',
                'description' => 'Reached Tier 2 (Bronze) in the affiliate program',
                'criteria' => json_encode([
                    'type' => 'tier',
                    'threshold' => 2,
                ]),
                'badge_image' => 'badges/tier_2.svg',
                'points_value' => 20,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tier 3',
                'description' => 'Reached Tier 3 (Silver) in the affiliate program',
                'criteria' => json_encode([
                    'type' => 'tier',
                    'threshold' => 3,
                ]),
                'badge_image' => 'badges/tier_3.svg',
                'points_value' => 50,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tier 4',
                'description' => 'Reached Tier 4 (Gold) in the affiliate program',
                'criteria' => json_encode([
                    'type' => 'tier',
                    'threshold' => 4,
                ]),
                'badge_image' => 'badges/tier_4.svg',
                'points_value' => 100,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tier 5',
                'description' => 'Reached Tier 5 (Platinum) in the affiliate program',
                'criteria' => json_encode([
                    'type' => 'tier',
                    'threshold' => 5,
                ]),
                'badge_image' => 'badges/tier_5.svg',
                'points_value' => 200,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('achievements')->insert($achievements);
    }
}
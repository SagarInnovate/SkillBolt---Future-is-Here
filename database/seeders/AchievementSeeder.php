<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Achievement;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $achievements = [
            [
                'name' => 'First Referral',
                'description' => 'Successfully referred your first user to SkillBolt!',
                'criteria' => [
                    'type' => 'referrals',
                    'threshold' => 1
                ],
                'badge_image' => 'badges/first_referral.svg',
                'points_value' => 10,
                'is_active' => true
            ],
            [
                'name' => 'Referral Pro',
                'description' => 'Successfully referred 5 users to SkillBolt!',
                'criteria' => [
                    'type' => 'referrals',
                    'threshold' => 5
                ],
                'badge_image' => 'badges/referral_pro.svg',
                'points_value' => 25,
                'is_active' => true
            ],
            [
                'name' => 'Referral Master',
                'description' => 'Successfully referred 10 users to SkillBolt!',
                'criteria' => [
                    'type' => 'referrals',
                    'threshold' => 10
                ],
                'badge_image' => 'badges/referral_master.svg',
                'points_value' => 50,
                'is_active' => true
            ],
            [
                'name' => 'Referral Champion',
                'description' => 'Successfully referred 25 users to SkillBolt!',
                'criteria' => [
                    'type' => 'referrals',
                    'threshold' => 25
                ],
                'badge_image' => 'badges/referral_champion.svg',
                'points_value' => 100,
                'is_active' => true
            ],
            [
                'name' => 'Referral Legend',
                'description' => 'Successfully referred 50 users to SkillBolt!',
                'criteria' => [
                    'type' => 'referrals',
                    'threshold' => 50
                ],
                'badge_image' => 'badges/referral_legend.svg',
                'points_value' => 250,
                'is_active' => true
            ],
            [
                'name' => 'First Earnings',
                'description' => 'Earned your first ₹300 from referrals!',
                'criteria' => [
                    'type' => 'earnings',
                    'threshold' => 300
                ],
                'badge_image' => 'badges/first_earnings.svg',
                'points_value' => 10,
                'is_active' => true
            ],
            [
                'name' => 'Rising Earner',
                'description' => 'Earned ₹1,500 from referrals!',
                'criteria' => [
                    'type' => 'earnings',
                    'threshold' => 1500
                ],
                'badge_image' => 'badges/rising_earner.svg',
                'points_value' => 25,
                'is_active' => true
            ],
            [
                'name' => 'Earning Expert',
                'description' => 'Earned ₹5,000 from referrals!',
                'criteria' => [
                    'type' => 'earnings',
                    'threshold' => 5000
                ],
                'badge_image' => 'badges/earning_expert.svg',
                'points_value' => 50,
                'is_active' => true
            ],
            [
                'name' => 'Earning Master',
                'description' => 'Earned ₹15,000 from referrals!',
                'criteria' => [
                    'type' => 'earnings',
                    'threshold' => 15000
                ],
                'badge_image' => 'badges/earning_master.svg',
                'points_value' => 100,
                'is_active' => true
            ],
            [
                'name' => 'Tier Climber',
                'description' => 'Reached Tier 2 in the affiliate program!',
                'criteria' => [
                    'type' => 'tier',
                    'threshold' => 2
                ],
                'badge_image' => 'badges/tier_2.svg',
                'points_value' => 25,
                'is_active' => true
            ],
            [
                'name' => 'Tier Advancer',
                'description' => 'Reached Tier 3 in the affiliate program!',
                'criteria' => [
                    'type' => 'tier',
                    'threshold' => 3
                ],
                'badge_image' => 'badges/tier_3.svg',
                'points_value' => 50,
                'is_active' => true
            ],
            [
                'name' => 'Tier Expert',
                'description' => 'Reached Tier 4 in the affiliate program!',
                'criteria' => [
                    'type' => 'tier',
                    'threshold' => 4
                ],
                'badge_image' => 'badges/tier_4.svg',
                'points_value' => 75,
                'is_active' => true
            ],
            [
                'name' => 'Tier Master',
                'description' => 'Reached the highest Tier 5 in the affiliate program!',
                'criteria' => [
                    'type' => 'tier',
                    'threshold' => 5
                ],
                'badge_image' => 'badges/tier_5.svg',
                'points_value' => 100,
                'is_active' => true
            ],
            [
                'name' => 'Top 10 Affiliate',
                'description' => 'Ranked in the top 10 on the affiliate leaderboard!',
                'criteria' => [
                    'type' => 'rank',
                    'threshold' => 10
                ],
                'badge_image' => 'badges/top_10.svg',
                'points_value' => 50,
                'is_active' => true
            ],
            [
                'name' => 'Top 3 Affiliate',
                'description' => 'Ranked in the top 3 on the affiliate leaderboard!',
                'criteria' => [
                    'type' => 'rank',
                    'threshold' => 3
                ],
                'badge_image' => 'badges/top_3.svg',
                'points_value' => 100,
                'is_active' => true
            ],
            [
                'name' => 'Leaderboard Champion',
                'description' => 'Reached the #1 position on the affiliate leaderboard!',
                'criteria' => [
                    'type' => 'rank',
                    'threshold' => 1
                ],
                'badge_image' => 'badges/number_1.svg',
                'points_value' => 200,
                'is_active' => true
            ]
        ];

        foreach ($achievements as $achievement) {
            Achievement::create([
                'name' => $achievement['name'],
                'description' => $achievement['description'],
                'criteria' => $achievement['criteria'],
                'badge_image' => $achievement['badge_image'],
                'points_value' => $achievement['points_value'],
                'is_active' => $achievement['is_active'],
            ]);
        }
    }
}
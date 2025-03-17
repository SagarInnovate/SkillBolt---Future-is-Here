<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('affiliate_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value');
            $table->string('description')->nullable();
            $table->enum('type', ['number', 'string', 'boolean', 'json'])->default('string');
            $table->timestamps();
        });

        // Insert default settings
        DB::table('affiliate_settings')->insert([
            ['key' => 'commission_rate', 'value' => '300', 'description' => 'Base commission rate in rupees per referral', 'type' => 'number', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'min_payout_threshold', 'value' => '1000', 'description' => 'Minimum balance required for payout request (in rupees)', 'type' => 'number', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'tier_requirements', 'value' => json_encode([
                '1' => ['referrals' => 0, 'bonus' => 0],
                '2' => ['referrals' => 5, 'bonus' => 50],
                '3' => ['referrals' => 15, 'bonus' => 100],
                '4' => ['referrals' => 30, 'bonus' => 200],
                '5' => ['referrals' => 50, 'bonus' => 300]
            ]), 'description' => 'Requirements for each tier level and tier bonuses', 'type' => 'json', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'leaderboard_refresh_hours', 'value' => '24', 'description' => 'How often the leaderboard refreshes in hours', 'type' => 'number', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'affiliate_program_active', 'value' => 'true', 'description' => 'Whether the affiliate program is currently active', 'type' => 'boolean', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('affiliate_settings');
    }
};

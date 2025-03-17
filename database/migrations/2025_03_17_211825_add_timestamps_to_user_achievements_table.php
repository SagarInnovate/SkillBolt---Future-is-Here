<?php
// database/migrations/2024_03_17_000009_add_timestamps_to_user_achievements_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // First, check if the user_achievements table exists and if it's missing timestamps
        if (Schema::hasTable('user_achievements') && 
            !Schema::hasColumn('user_achievements', 'created_at')) {
            
            Schema::table('user_achievements', function (Blueprint $table) {
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        // This is technically not reversible without losing data
        // But we can include it for completeness
        if (Schema::hasTable('user_achievements') && 
            Schema::hasColumn('user_achievements', 'created_at')) {
            
            Schema::table('user_achievements', function (Blueprint $table) {
                $table->dropTimestamps();
            });
        }
    }
};
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // First check if the table exists
        if (Schema::hasTable('affiliate_details')) {
            // Add new columns to existing affiliate_details table
            Schema::table('affiliate_details', function (Blueprint $table) {
                if (!Schema::hasColumn('affiliate_details', 'status')) {
                    $table->enum('status', ['active', 'inactive', 'suspended'])->default('active')->after('affiliate_code');
                }
                if (!Schema::hasColumn('affiliate_details', 'tier_level')) {
                    $table->tinyInteger('tier_level')->default(1)->after('status');
                }
                if (!Schema::hasColumn('affiliate_details', 'total_earnings')) {
                    $table->decimal('total_earnings', 10, 2)->default(0)->after('tier_level');
                }
                if (!Schema::hasColumn('affiliate_details', 'available_balance')) {
                    $table->decimal('available_balance', 10, 2)->default(0)->after('total_earnings');
                }
                if (!Schema::hasColumn('affiliate_details', 'successful_referrals')) {
                    $table->integer('successful_referrals')->default(0)->after('total_referrals');
                }
                if (!Schema::hasColumn('affiliate_details', 'qr_code_path')) {
                    $table->string('qr_code_path')->nullable()->after('successful_referrals');
                }
            });
        } else {
            // Create the affiliate_details table if it doesn't exist
            Schema::create('affiliate_details', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
                $table->string('affiliate_code', 50)->unique();
                $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
                $table->tinyInteger('tier_level')->default(1);
                $table->decimal('total_earnings', 10, 2)->default(0);
                $table->decimal('available_balance', 10, 2)->default(0);
                $table->integer('total_referrals')->default(0);
                $table->integer('successful_referrals')->default(0);
                $table->string('qr_code_path')->nullable();
                $table->timestamps();
                
                $table->index('affiliate_code');
            });
        }
    }

    public function down()
    {
        // If you created the table in this migration, drop it
        if (!Schema::hasTable('affiliate_details_original')) {
            Schema::dropIfExists('affiliate_details');
        } else {
            // Otherwise just remove the columns you added
            Schema::table('affiliate_details', function (Blueprint $table) {
                $table->dropColumn([
                    'status',
                    'tier_level',
                    'total_earnings',
                    'available_balance',
                    'successful_referrals',
                    'qr_code_path'
                ]);
            });
        }
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('affiliate_details', function (Blueprint $table) {
            // Add a field to track if balances have been reconciled
            $table->timestamp('last_reconciled_at')->nullable();
            
            // Add indexes for better performance
            $table->index(['user_id', 'affiliate_code']);
        });
    }

    public function down(): void
    {
        Schema::table('affiliate_details', function (Blueprint $table) {
            $table->dropColumn('last_reconciled_at');
            $table->dropIndex(['user_id', 'affiliate_code']);
        });
    }
};
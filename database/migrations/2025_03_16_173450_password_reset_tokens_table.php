<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First check if the table already exists - Laravel might have created it
        if (!Schema::hasTable('password_reset_tokens')) {
            Schema::create('password_reset_tokens', function (Blueprint $table) {
                $table->string('email')->primary();
                $table->string('token');
                $table->timestamp('created_at')->nullable();
            });
        } else {
            // If it exists, we'll alter it to ensure it has the columns we need for our OTP system
            if (!Schema::hasColumn('password_reset_tokens', 'created_at')) {
                Schema::table('password_reset_tokens', function (Blueprint $table) {
                    $table->timestamp('created_at')->nullable();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We don't want to drop this table if Laravel created it
        // So we do nothing here
    }
};